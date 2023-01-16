<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

  <x-head />

  <title>@yield('title') | {{ get_setting('siteName') }}</title>

  {{-- /* 不同屏幕宽度下的主界面宽度 */ --}}
  @if (get_setting('web_page_display_wide'))
    <style type="text/css">
      @media screen and (max-width: 1200px) {
        .container {
          max-width: 1200px;
        }
      }

      @media screen and (min-width: 1201px) {
        .container {
          max-width: 96%;
        }
      }
    </style>
  @endif

</head>

<body>

  {{-- 深色模式，必须首先载入，否则会有闪现白页等延迟现象 --}}
  @if (get_setting('web_page_dark_mode'))
    <x-dark-mode />
  @endif

  {{-- 页面载入动画（管理员可在后台系统设置中手动关闭） --}}
  @if (get_setting('web_page_loading_animation'))
    <x-loading-animation />
  @endif

  {{-- 判断如果是从404重定向过来的，则显示提示窗口 --}}
  @if (($_GET['http_error'] ?? 0) == 404)
    <script type="text/javascript">
      $(function() {
        Notiflix.Report.Failure('404', '您访问的页面不存在，可能相应的资源已被删除或者迁移，已为您跳转到首页。', '好的')
      })
    </script>
  @endif

  {{-- 检查微信浏览器，不允许使用微信浏览器 --}}
  @if (stripos($_SERVER['HTTP_USER_AGENT'], 'wechat') !== false ||
      (stripos($_SERVER['HTTP_USER_AGENT'], 'chrome') === false &&
          stripos($_SERVER['HTTP_USER_AGENT'], 'safari') === false))
    <div class="w-100 p-3">
      <p class="p-3 alert-danger">
        <strong>请使用Edge浏览器或Google Chrome浏览器访问本站！否则部分功能将无法使用！</strong>
        <br>
        您可以将本站网址复制下来，输入到浏览器的地址栏中，按回车即可访问。
      </p>
      @if (isset($_SERVER['HTTP_HOST']))
        <p class="p-3 alert-info">
          本站网址 {{ $_SERVER['HTTP_HOST'] }}
        </p>
      @endif
      <p class="p-3 alert-danger">
        如果您还没有安装Edge浏览器或Google Chrome浏览器，请安装！
        <br><br>
        Edge浏览器下载地址
        <a href="https://www.microsoft.com/zh-cn/edge">www.microsoft.com/zh-cn/edge</a>
        <br>
        Google Chrome浏览器下载地址
        <a href="https://www.google.cn/intl/zh-cn/chrome">www.google.cn/intl/zh-cn/chrome</a>
      </p>
    </div>
  @endif

  {{-- 前台导航栏 --}}
  <nav class="navbar navbar-expand-lg navbar-light bg-white mb-3" style="z-index: 10">
    {{-- 网站名称 --}}
    <a class="navbar-brand text-center" style="min-width: 200px">{{ get_setting('siteName') }}</a>
    {{-- 导航栏菜单项 --}}
    <x-navbar />
  </nav>

  {{-- 滚动公告；除了题目页面外，都要显示 --}}
  @if (!in_array(Route::currentRouteName(), ['problem', 'contest.problem']))
    <div class="container">
      <x-marquee />
    </div>
  @endif

  {{-- 主界面 --}}
  @yield('content')

  {{-- 页脚 --}}
  <x-footer />

  <script>
    //通用提示框，小问号提示这是什么
    function whatisthis(text) {
      Notiflix.Report.Init({
        plainText: false, //使<br>可以换行
      });
      Notiflix.Report.Info('{{ __('sentence.Whats this') }}', text, '{{ __('main.Confirm') }}');
    }
  </script>
</body>

</html>
