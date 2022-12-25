<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\View\Components\Contest\ProblemsLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ContestController extends Controller
{
    public function contests()
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        //获取类别
        $current_cate = DB::table('contest_cate')->find($_GET['cate'] ?? 0);

        //类别不存在，则自动跳转到默认竞赛(可能是cookie保存的)
        if (!$current_cate) {
            $current_cate = DB::table('contest_cate')
                ->find(request()->cookie('unencrypted_contests_default_cate'));
            if (!$current_cate) // cookie保存的类别也不存在，则直接取第一个类别
                $current_cate = DB::table('contest_cate')->first();
            if (!$current_cate)
                return view('message', ['msg' => '竞赛中没有任何可用类别，请管理员前往后台添加类别！']);
        }

        // 获取父类别（有可能不存在，则为null）
        $current_cate->parent = DB::table('contest_cate')->select(['title'])->find($current_cate->parent_id);

        // cookie记下上次访问的类别，下次默认直接访问它
        Cookie::queue('unencrypted_contests_default_cate', $current_cate->id, 5256000); // 10 years

        // 拿到所有的类别
        $categories = DB::table('contest_cate as cc')
            ->leftJoin('contest_cate as father', 'father.id', 'cc.parent_id')
            ->select([
                'cc.id', 'cc.title', 'cc.description', 'cc.hidden',
                'cc.order', 'cc.parent_id',
                'cc.updated_at', 'cc.created_at',
                'father.title as parent_title',
                DB::raw('(case cc.parent_id when 0 then 1 else 0 end) as is_parent'),
                DB::raw('(case cc.parent_id when 0 then cc.id else cc.parent_id end) as l1_cate')
            ])
            ->orderBy('l1_cate') // 1 全局，统一按一级类别的order，同一大类挨在一起
            ->orderByDesc('is_parent') // 2 同一父类下，父类排在首位
            ->orderBy('cc.order') // 3 同一父类下的二级类别，按自身order排序
            ->get();

        //cookie记下默认每页显示的条数
        if (isset($_GET['perPage'])) {
            Cookie::queue('unencrypted_contests_default_perpage', $_GET['perPage'], 5256000); // 10 years
        } else {
            $_GET['perPage'] = (request()->cookie('unencrypted_contests_default_perpage') ?? 10);
        }

        $contests = DB::table('contests as c')
            ->select([
                'c.id', 'judge_type', 'c.title', 'start_time', 'end_time',
                'access', 'c.order', 'c.hidden',
                'password',
                'num_members'
            ])
            ->where('cate_id', $current_cate->id)
            ->when(in_array($_GET['state'] ?? null, ['waiting', 'running', 'ended']), function ($q) {
                if ($_GET['state'] == 'ended') return $q->where('end_time', '<', date('Y-m-d H:i:s'));
                else if ($_GET['state'] == 'waiting') return $q->where('start_time', '>', date('Y-m-d H:i:s'));
                else return $q->where('start_time', '<', date('Y-m-d H:i:s'))->where('end_time', '>', date('Y-m-d H:i:s'));
            })
            ->when(in_array($_GET['judge_type'] ?? null, ['acm', 'oi']), function ($q) {
                return $q->where('c.judge_type', $_GET['judge_type']);
            })
            ->when(isset($_GET['title']) && $_GET['title'] != null, function ($q) {
                return $q->where('c.title', 'like', '%' . $_GET['title'] . '%');
            })
            ->when(!Auth::check() || !$user->can('admin.contest.view'), function ($q) {
                return $q->where('c.hidden', 0); // 没登陆 or 登陆了但没权限，则隐藏
            })
            ->orderByDesc('c.order')
            ->paginate($_GET['perPage'] ?? 10);

        return view('contest.contests', compact('contests', 'categories', 'current_cate'));
    }

    public function password(Request $request, $id)
    {
        // 验证密码
        if ($request->isMethod('get')) {
            $contest = DB::table('contests')->select('id', 'judge_type', 'cate_id', 'title', 'public_rank')->find($id);
            return view('contest.password', compact('contest'));
        }
        if ($request->isMethod('post')) //接收提交的密码
        {
            $contest = DB::table('contests')->select('id', 'judge_type', 'password', 'cate_id', 'title', 'public_rank')->find($id);
            if ($request->input('pwd') == $contest->password) //通过验证
            {
                DB::table('contest_users')->updateOrInsert(['contest_id' => $contest->id, 'user_id' => Auth::id()]); //保存
                return redirect(route('contest.home', $contest->id));
            } else {
                $msg = trans('sentence.pwd wrong');
                return view('contest.password', compact('contest', 'msg'));
            }
        }
    }

    // 竞赛首页概览 题目列表
    public function home($id)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        // 拿到竞赛
        $contest = DB::table('contests')
            ->select([
                'id', 'title', 'description', 'cate_id',
                'start_time', 'end_time',
                'judge_type',
                'access', 'password',
                'public_rank',
                'num_members'
            ])->find($id);
        if (!$contest)
            return abort(404);

        // 获取题目信息
        $problem_link = new ProblemsLink($id, null);
        $problems = $problem_link->problems;

        // 读取标签（有缓存）
        if ($user->can('admin.contest.view') || time() > strtotime($contest->end_time))
            foreach ($problems as &$problem) {
                $problem->tags = ProblemController::get_problem_tags($problem->id);
            }

        //读取附件，位于storage/app/public/contest/files/$cid/*
        $files = [];
        foreach (Storage::allFiles('public/contest/files/' . $id) as &$item) {
            $files[] = [
                array_slice(explode('/', $item), -1, 1)[0], //文件名
                Storage::url($item),   //url
            ];
        }

        return view('contest.home', compact('contest', 'problems', 'files'));
    }

    // 题目详情
    public function problem($id, $pid)
    {
        // 拿到竞赛信息
        $contest = DB::table('contests')
            ->select([
                'id', 'title', 'cate_id',
                'start_time', 'end_time',
                'judge_type', 'public_rank',
                'allow_lang',
                'open_discussion'
            ])->find($id);

        // 拿到本题基本信息
        $problem = DB::table('problems as p')
            ->join('contest_problems as cp', 'cp.problem_id', '=', 'p.id')
            ->select([
                'cp.index', 'hidden', 'problem_id as id', 'title', 'description',
                'language', // 代码填空的语言
                'input', 'output', 'hint', 'source', 'time_limit', 'memory_limit', 'spj',
                'type', 'fill_in_blank',
                'cp.accepted', 'cp.solved', 'cp.submitted'
            ])
            ->where('contest_id', $id)
            ->where('cp.index', $pid)
            ->first();

        if (!$problem) // 题目不存在! 跳回前一页
            return back();

        // 读取这道题的样例数据
        $samples = read_problem_data($problem->id);

        // 特判代码是否存在
        $hasSpj = file_exists(testdata_path($problem->id . '/spj/spj.cpp'));

        // 获取本题的tag
        $tags = ProblemController::get_problem_tags($problem->id, 5);

        return view('problem.problem', compact('contest', 'problem', 'samples', 'hasSpj', 'tags'));
    }

    // 竞赛提交记录
    public function solutions($id)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        // 拿到竞赛信息
        $contest = DB::table('contests')
            ->select([
                'id', 'title', 'cate_id',
                'start_time', 'end_time',
                'judge_type', 'public_rank',
                'allow_lang',
                'open_discussion'
            ])->find($id);

        // 判断比赛状态: 比赛没结束，普通用户只能看自己
        if (time() < strtotime($contest->end_time) && !$user->can('admin.contest.view'))
                $_GET['user_id'] = Auth::id();

        // 获得题号映射数组 [problem_id => index]
        $pid2index = DB::table('contest_problems')->where('contest_id', $id)
            ->orderBy('index')
            ->pluck('index', 'problem_id')
            ->toArray();

        // 获取提交记录
        $solutions = DB::table('solutions as s')
            ->join('users as u', 's.user_id', '=', 'u.id')
            ->select([
                'user_id', 'username', 'nick', // 用户信息
                's.id', 'problem_id', 'judge_type', 'language', 'submit_time', 'ip', 'ip_loc',
                'result', 'pass_rate', 'sim_rate', 'sim_sid', 'time', 'memory', 'judger'
            ])
            ->where('s.contest_id', $id)
            ->when(isset($_GET['index']) && $_GET['index'] >= 0, function ($q) use ($pid2index) {
                return $q->where('problem_id', array_search($_GET['index'], $pid2index));
            })
            ->when(isset($_GET['user_id']) && $_GET['user_id'] >= 0, function ($q) {
                return $q->where('user_id', $_GET['user_id']);
            })
            ->when(intval($_GET['sim_rate'] ?? 0) > 0, function ($q) {
                return $q->where('sim_rate', '>=', $_GET['sim_rate']); // 0~100
            })
            ->when(isset($_GET['username']) && $_GET['username'] != null, function ($q) {
                return $q->where('username', 'like', $_GET['username'] . '%');
            })
            ->when(isset($_GET['result']) && $_GET['result'] >= 0, function ($q) {
                return $q->where('result', $_GET['result']);
            })
            ->when(isset($_GET['language']) && $_GET['language'] >= 0, function ($q) {
                return $q->where('language', $_GET['language']);
            })
            ->when(isset($_GET['ip']) && $_GET['ip'] != null, function ($q) {
                return $q->where('ip', $_GET['ip']);
            })
            ->when(isset($_GET['top_id']) && $_GET['top_id'] != null, function ($q) {
                if (isset($_GET['reverse']) && $_GET['reverse'] == 1)
                    return $q->where('s.id', '>=', $_GET['top_id']);
                return $q->where('s.id', '<=', $_GET['top_id']);
            })
            ->orderBy('s.id', (isset($_GET['reverse']) && $_GET['reverse'] == 1) ? 'asc' : 'desc')
            ->limit(10)->get();

        if (isset($_GET['reverse']) && $_GET['reverse'] == 1)
            $solutions = $solutions->reverse();

        // 计算题目在竞赛中的题号[0,1,2,...]
        foreach ($solutions as &$s) {
            $s->index = $pid2index[$s->problem_id] ?? ($s->problem_id - 1); // 注意已删除的题目不在竞赛题号列表中
        }
        return view('solution.solutions', compact('contest', 'solutions', 'pid2index'));
    }

    // 获取榜单
    public function rank($id)
    {
        $contest = DB::table('contests')->find($id);

        // 首先判断榜单的可访问性。如果榜单未公开，则只允许参赛选手和管理员查看
        if (!$contest->public_rank && Route::currentRouteName() == 'contest.rank') {
            return redirect(route('contest.private_rank', $id));
        }

        //对于隐藏的竞赛，普通用户不能查看榜单
        /** @var \App\Models\User */
        $user = Auth::user();
        if ($contest->hidden && !$user->can('admin.contest.view')) {
            return view('message', ['msg' => '该竞赛处于隐藏状态，不可查看榜单。']);
        }

        // ======================= 计算榜单结束时间 ======================
        // 注意：普通用户在封榜后受限制
        $rank_time = [
            'locked_time' => [],
            'final_time' => [],
            'real_time' => [],
        ];
        // 封榜时间；time: 时刻, date: 日期格式, able: 是否有效, show是否展示按钮
        $rank_time['locked_time']['time'] = strtotime($contest->start_time) + (1 - $contest->lock_rate) * (strtotime($contest->end_time) - strtotime($contest->start_time));
        $rank_time['locked_time']['date'] = date('Y-m-d H:i:s', $rank_time['locked_time']['time']);
        if ($contest->lock_rate > 0 && $rank_time['locked_time']['time'] < time()) {
            $rank_time['locked_time']['able'] = true; // 允许查看封榜榜单
        } else {
            $rank_time['locked_time']['able'] = false;
        }
        $rank_time['locked_time']['show'] = $contest->lock_rate > 0; // 是否显示封榜按钮

        // 终榜时间
        $rank_time['final_time']['time'] = strtotime($contest->end_time);
        $rank_time['final_time']['date'] = $contest->end_time;
        if ($rank_time['final_time']['time'] < time()) // 竞赛已结束
        {
            $rank_time['final_time']['show'] = true;
            $rank_time['final_time']['able'] = true;
        } else {
            $rank_time['final_time']['able'] = false;
        }
        $rank_time['final_time']['show'] = true; // 始终显示终榜按钮

        // 实时时间
        $rank_time['real_time']['time'] = time();
        $rank_time['real_time']['date'] = date('Y-m-d H:i:s');
        $rank_time['real_time']['show'] = true;
        $rank_time['real_time']['able'] = true;

        // 普通用户在封榜后，应当禁用终榜、实时
        /** @var \App\Models\User */
        $user = Auth::user();
        if ($rank_time['locked_time']['able'] && !$user->can('admin.contest.view')) {
            $rank_time['final_time']['able'] = false;
            $rank_time['real_time']['able'] = false;
        }

        // ====================== 解析用户请求的截止榜单 ==============
        if (!isset($_GET['end']) || !in_array($_GET['end'], array_keys($rank_time))) // 不合法的参数改为默认值real_time
            $_GET['end'] = 'real_time';
        if ($rank_time['real_time']['able'] === false) // real_time不允许查看，则切换为封榜
            $_GET['end'] = 'locked_time';


        // ======================= 获取题单 =========================
        $problems = DB::table('contest_problems')
            ->where('contest_id', $contest->id)
            ->orderBy('index')
            ->pluck('index', 'problem_id'); // [problem_id => index, ...]


        // ======================== 计算榜单 =======================
        $calculate_rank = function ($contest, $end_date = null) use ($problems) {
            // 查询所有提交记录
            $solutions = DB::table('solutions as s')
                ->join('users', 's.user_id', '=', 'users.id')
                ->select([
                    'problem_id', 'result', 'pass_rate', 'time', 'memory', 'submit_time',
                    'user_id', 'username', 'school', 'class', 'nick'
                ])
                ->where('s.contest_id', $contest->id)
                ->whereBetween('result', [4, 10])
                ->where('submit_time', '>=', $contest->start_time)
                ->when(isset($end_date), function ($q) use ($end_date) {
                    return $q->where('submit_time', '<', $end_date);
                })
                ->get();

            // 生成榜单（重量级）
            $users = [];
            $problem_was_solved = []; // 标记每道题是否已经被AC
            foreach ($solutions as $solution) {
                // 获取题目序号
                if (!isset($problems[$solution->problem_id]))
                    continue; // 说明这条记录对应的题目已经从竞赛中删除了
                $index = $problems[$solution->problem_id];

                // 用户首次提交，先创建用户
                if (!isset($users[$solution->user_id])) {
                    $users[$solution->user_id] = [
                        'solved' => 0, // acm解决题目数量
                        'penalty' => 0, // acm罚时
                        'score' => 0, // oi得分
                        'username' => $solution->username,
                        'school' => $solution->school,
                        'class' => $solution->class,
                        'nick' => $solution->nick,
                    ];
                }
                $user = &$users[$solution->user_id];

                // 用户user对于题目index是首次提交，则初始化
                if (!isset($user[$index])) {
                    $user[$index] = [
                        'solved_time' => null, // 解决时间，若为null则表示尚未解决
                        'solved_first' => false, // 是否是最快解决的
                        'solved_after_end' => false, // 比赛结束后AC的
                        'tries' => 0, // 直到解决时的尝试次数
                        'score' => 0, // 得分（百分制）
                    ];
                }
                // 用户user对于题目index还未解决
                if (!$user[$index]['solved_time']) {
                    if ($solution->result == 4) { // 该用户首次AC该题目
                        $user[$index]['solved_time'] = strtotime($solution->submit_time) - strtotime($contest->start_time);
                        if ($solution->submit_time > $contest->end_time) // 赛后AC
                            $user[$index]['solved_after_end'] = true;
                        else if (!isset($problem_was_solved[$index])) { // 比赛中一血
                            $user[$index]['solved_first'] = true;
                            $problem_was_solved[$index] = true;
                        }
                        // acm过题数、罚时
                        $user['solved']++;
                        $user['penalty'] += $user[$index]['tries'] * intval(get_setting('penalty_acm')) + $user[$index]['solved_time'];
                    }
                    // oi得分，以最后得分为准
                    $user['score'] -= $user[$index]['score'];
                    $user[$index]['score'] = $solution->pass_rate * 100; //百分制
                    $user['score'] += $user[$index]['score']; // oi得分
                    // 尝试次数
                    $user[$index]['tries']++;
                }
            }

            // 排序
            uasort($users, $contest->judge_type == 'acm' ?
                function ($x, $y) {
                    if ($x['solved'] != $y['solved'])
                        return $x['solved'] < $y['solved'];
                    return $x['penalty'] > $y['penalty'];
                }
                : // oi
                function ($x, $y) {
                    if ($x['score'] != $y['score'])
                        return $x['score'] < $y['score'];
                    return $x['penalty'] > $y['penalty'];
                });

            // 标记名次
            $rank = 0;
            foreach ($users as $uid => &$user) {
                $user['rank'] = ++$rank;
            }
            return $users;
        };


        // ========================== 调用榜单 ============================
        $users = [];
        $key = sprintf('contest:%d:rank:%s:users', $contest->id, $_GET['end']);
        clear_cache_if_rejudged($key); // 若发生了重判，先清除缓存，迫使下方业务重新计算榜单
        if (Cache::has($key))
            $users = Cache::get($key);
        else {
            // 由于榜单计算非常耗时，加锁避免高并发，确保并发时，榜单只被计算一次
            // 举例：若A得到了锁，则会计算结束后释放锁，同时将结果压入缓存；B等到锁后，直接通过remember获取缓存，避免重复计算
            Cache::lock('lock:' . $key, 15)->block(10, function () use ($key, $contest, $calculate_rank, $rank_time, &$users) {
                // 原子锁的生命周期最长 15秒；等待最多 10 秒后获得锁，否则抛出异常
                if ($_GET['end'] == 'real_time') // 实时榜单，缓存15秒
                    $users = Cache::remember($key, 15, function () use ($contest, $calculate_rank) {
                        return $calculate_rank($contest);
                    });
                else // 封榜或终榜，已经固定，长期缓存
                    $users = Cache::remember($key, 3600 * 24 * 30, function () use ($contest, $calculate_rank, $rank_time) {
                        return $calculate_rank($contest, $rank_time[$_GET['end']]['date']);
                    });
            });
        }

        // =========================== 模糊查询 ========================
        foreach ($users as $uid => &$user) {
            if (isset($_GET['school']) && $_GET['school'] != '' && stripos($user['school'], $_GET['school']) === false) unset($users[$uid]);
            if (isset($_GET['class']) && $_GET['class'] != '' && stripos($user['class'], $_GET['class']) === false) unset($users[$uid]);
            if (isset($_GET['nick']) && $_GET['nick'] != '' && stripos($user['nick'], $_GET['nick']) === false) unset($users[$uid]);
            if (isset($_GET['username']) && $_GET['username'] != '' && stripos($user['username'], $_GET['username']) === false) unset($users[$uid]);
        }
        return view('contest.rank', compact('contest', 'users', 'problems', 'rank_time'));
    }

    // 竞赛公告
    public function notices($id)
    {
        $notices = DB::table('contest_notices')
            ->where('contest_id', $id)
            ->orderByDesc('id')
            ->get();
        $contest = DB::table('contests')->find($id);
        return view('contest.notices', compact('contest', 'notices'));
    }

    // 读取竞赛公告内容
    public function get_notice(Request $request, $id)
    {
        //post
        $notice = DB::table('contest_notices')->select(['title', 'content', 'created_at'])->find($request->input('nid'));
        return json_encode($notice);
    }

    // 编辑公告
    public function edit_notice(Request $request, $id)
    {
        //post
        $notice = $request->input('notice');
        if ($notice['id'] == null) {
            //new
            unset($notice['id']);
            $notice['contest_id'] = $id;
            DB::table('contest_notices')->insert($notice);
        } else {
            //update
            DB::table('contest_notices')->where('id', $notice['id'])->update($notice);
        }
        return back();
    }

    // 删除竞赛公告
    public function delete_notice($id, $nid)
    {
        //post
        DB::table('contest_notices')->where('id', $nid)->delete();
        return back();
    }

    // 显示气球列表
    public function balloons($id)
    {
        $contest = DB::table('contests')->find($id);
        //扫描新增AC记录，添加到气球队列
        $max_added_sid = DB::table('contest_balloons')
            ->join('solutions', 'solutions.id', '=', 'solution_id')
            ->where('contest_id', $id)->max('solution_id');
        $new_solutions = DB::table('solutions')
            ->where('contest_id', $id)
            ->where('result', 4)
            ->where('id', '>', $max_added_sid ?: 0)
            ->get();
        $new_balloons = [];
        foreach ($new_solutions as $item) {
            $q = DB::table('contest_balloons')
                ->join('solutions', 'solutions.id', '=', 'solution_id')
                ->where('contest_id', $item->contest_id)
                ->where('problem_id', $item->problem_id)
                ->where('user_id', $item->user_id)
                ->exists();
            if (!$q) // 气球已存在，无需重复添加
                $new_balloons[] = ['solution_id' => $item->id];
        }
        DB::table('contest_balloons')->insert($new_balloons);

        //读取气球队列
        $balloons = DB::table('contest_balloons')
            ->join('solutions', 'solutions.id', '=', 'solution_id')
            ->join('contest_problems', 'solutions.problem_id', '=', 'contest_problems.problem_id')
            ->leftJoin('users', 'solutions.user_id', '=', 'users.id')
            ->select(['contest_balloons.id', 'solution_id', 'username', 'index', 'sent', 'send_time'])
            ->where('solutions.contest_id', $id)
            ->where('contest_problems.contest_id', $id)
            ->orderBy('sent')
            ->orderByDesc('send_time')
            ->orderBy('contest_balloons.id')
            ->paginate();

        return view('contest.balloons', compact('contest', 'balloons'));
    }

    // 动作：派送气球
    public function deliver_ball($id, $bid)
    {
        //送一个气球，更新一条气球记录
        DB::table('contest_balloons')->where('id', $bid)->update(['sent' => 1, 'send_time' => date('Y-m-d H:i:s')]);
        return back();
    }
}