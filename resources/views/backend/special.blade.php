@extends('backend.layout')

@section('pageTitle', '专题管理')

@section('extraMeta')

@endsection

@section('content')
    <h1 class="page-header">专题管理</h1>

    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('admin.special.edit_special') }}" class="btn btn-success">添加专题</a>
        </div>
        <div class="col-md-6">

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead class="bg-primary">
                <tr>
                    <th>专题id</th>
                    <th>专题名</th>
                    <th>创建人</th>
                    <th>描述</th>
                    <th>文章列表</th>
                    <th>接收人邮箱</th>
                    <th>时间</th>
                    <th>是否已发送</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($topics as $topic)
                    <tr>
                        <th>{{ $topic->id }}</th>
                        <th>{{ $topic->title }}</th>
                        <th>{{ $topic->user_id }}</th>
                        <th>{{ $topic->desc }}</th>
                        <th>{{ $topic->article_list }}</th>
                        <th>{{ $topic->accept_email }}</th>
                        <th>创建时间：{{ $topic->created_at }}<br/>
                            更新时间：{{ $topic->updated_at }}<br/>
                            发送时间：{{ $topic->send_time }}
                        </th>
                        <th>{{ $topic->flag_send?'是':'否' }}</th>
                        <th>
                            {{ Html::Link('admin/edit_special/'.$topic->id, "编辑", ['class'=>'btn btn-small btn-primary']) }}
                            {{--<button data-id="{{$topic->id}}" class="btn btn-small btn-danger btn-delete">删除</button>--}}
                            <span class="btn btn-small btn-danger btn-delete" data-type="{{$topic->id}}">删除</span>
                            {{ Html::Link('admin/special/'.$topic->id, "预览", ['class'=>'btn btn-small btn-primary']) }}
                            <button data-id="{{$topic->id}}" class="btn btn-small btn-primary js_send_email">发送</button>
                        </th>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">当前还没有专题</td>
                    </tr>
                @endforelse

                </tbody>
            </table>

            <div class="container page_container">
                <nav>
{{--                    {{$articles->render() }}--}}
                </nav>
            </div>

        </div>
    </div>


@endsection

@section('pageScript')
    <script src="//game.gtimg.cn/images/js/devfeed/v2017/ossweb-img/js/jquery.min.js"></script>
    <script>
        $('.js_send_email').on('click',function () {
            var postData = {
                'id' : $(this).attr('data-id')
            };
            $.ajax({
                url: "//www.devfeed.cn/admin/send_special",
                type: "post",
                dataType: "json",
                data:postData,
                timeout: 10000,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if(data.errcode == 0){
                        alert(data.errmsg);
                        location.reload();
                    }else{
                        alert(data.errmsg);
                    }
                },
                error: function () {
                    alert(data.errmsg);
                }
            });
        })
        $('.btn-delete').on('click',function () {
            var sId= $(this).attr('data-type');
            if(confirm('删除后将不能恢复，是否确认删除？')){
                d();
            }
            function d() {
                $.ajax({
                    url: "//devfeed.cn/admin/delete_special",
                    type: "post",
                    dataType: "json",
                    data:{'id':sId},
                    timeout: 10000,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        alert('删除成功');
                        location.reload();
                    },
                    error: function (data) {
                        alert(data.errmsg);
                    }
                });
            }
        })
    </script>
@endsection
