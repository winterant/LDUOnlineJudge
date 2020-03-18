@extends('layouts.client')

@section('title',trans('main.Notification').$contest->id.' | '.config('oj.main.siteName'))

@section('content')

    <div class="container">

        <div class="col-12 col-sm-12">
            {{-- 菜单 --}}
            @include('contest.menu')
        </div>

        <div class="col-12">
            <div class="my-container bg-white">

                <h3 class="text-center">{{$contest->id}}. {{$contest->title}}</h3>
                <hr class="mt-0">
                @if(Auth::user()->privilege('contest'))
                    <button class="btn btn-info" data-toggle="modal" data-target="#edit_notice"
                        onclick="$('#form_edit_notice')[0].reset()">{{__('main.New Notice')}}</button>
                @endif
                <table class="table table-sm table-hover">
                    <thead>
                    <tr>
                        <th class="text-left">&nbsp;{{trans('main.Title')}}</th>
                        <th width="20%">{{trans('main.Time')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($notices as $item)
                        <tr>
                            <td class="text-left">
                                <a href="javascript:" onclick="get_notice({{$item->id}})" data-toggle="modal" data-target="#myModal">{{$item->title}}</a>
                                @if(Auth::user()->privilege('contest'))
                                    <div class="float-right">
                                        <a href="javascript:" class="pl-3 text-sky" data-toggle="modal"
                                           onclick="edit_notice({{$item->id}})" data-target="#edit_notice">
                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                        </a>
                                        <form class="d-inline" method="post" action="{{route('contest.delete_notice',[$contest->id,$item->id])}}">
                                            @csrf
                                            <a href="javascript:" onclick="$(this).parent().submit()" class="pl-1 text-sky">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        </form>
                                    </div>
                                @endif
                            </td>
                            <td>{{$item->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{--    模态框,显示公告内容 --}}
                <div class="modal fade" id="myModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <!-- 模态框头部 -->
                            <div class="modal-header">
                                <h4 id="notice-title" class="modal-title"></h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- 模态框主体 -->
                            <div id="notice-content" class="modal-body ck-content"></div>

                            <!-- 模态框底部 -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            @if(Auth::user()->privilege('contest'))
{{--                模态框，管理员编辑公告 --}}
                <div class="modal fade" id="edit_notice">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <!-- 模态框头部 -->
                            <div class="modal-header">
                                <h4 id="notice-title" class="modal-title">{{__('main.Notification')}}</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- 模态框主体 -->
                            <div id="notice-content" class="modal-body ck-content">
                                <form id="form_edit_notice" action="{{route('contest.edit_notice',$contest->id)}}" method="post">
                                    @csrf
                                    <input id="form_notice_id" type="number" name="notice[id]" hidden>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{__('main.Title')}}：</span>
                                        </div>
                                        <input id="form_title" type="text" name="notice[title]" required autocomplete="off" class="form-control">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="description">{{__('main.Content')}}：</label>
                                        <textarea id="content" name="notice[content]" class="form-control-plaintext border bg-white"></textarea>
                                    </div>
                                </form>
                            </div>

                            <!-- 模态框底部 -->
                            <div class="modal-footer p-4">
                                <button type="button" class="btn btn-success" onclick="$('#form_edit_notice').submit()">{{__('main.Submit')}}</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('main.Cancel')}}</button>
                            </div>

                        </div>
                    </div>
                </div>

            @endif
        </div>

    </div>



    <script src="{{asset('static/ckeditor5-build-classic/ckeditor.js')}}"></script> {{-- ckeditor样式 --}}
    <script src="{{asset('static/ckeditor5-build-classic/translations/zh-cn.js')}}"></script>
    <script>

        //编辑框配置
        var config={
            language: "zh-cn",
            ckfinder: {
                {{--uploadUrl: '{{route('admin.problem.upload_image',['_token'=>csrf_token()])}}'--}}
            }
        };
        //各个编辑框ckeditor
        var editor=ClassicEditor.create(document.querySelector('#content'), config).then(editor => {
            window.editor = editor;
            console.log(editor.getData());
        } ).catch(error => {
            console.log(error);
        } );


        function get_notice(nid) {
            $.post(
                '{{route('contest.get_notice',$contest->id)}}',
                {
                    '_token':'{{csrf_token()}}',
                    'nid':nid
                },
                function (ret) {
                    ret=JSON.parse(ret);
                    console.log(ret)
                    $("#notice-title").html(ret.title)
                    $("#notice-content").html(ret.content + "<div class='text-right mt-3'>"+ret.created_at+"</div>")
                }
            );
        }

        function edit_notice(nid) {
            $.post(
                '{{route('contest.get_notice',$contest->id)}}',
                {
                    '_token':'{{csrf_token()}}',
                    'nid':nid
                },
                function (ret) {
                    ret=JSON.parse(ret);
                    $("#form_notice_id").val(nid);
                    $("#form_title").val(ret.title);
                    editor.setData(ret.content)
                }
            );
        }
    </script>
@endsection
