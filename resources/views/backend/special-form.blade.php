@extends('backend.layout')

@section('pageTitle', '新增专题')

@section('extraMeta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    {{ Form::model($special,['action'=>['Admin\SpecialController@save', $special->id],'class'=>'article-form', 'id'=>'articleForm', 'enctype'=>'multipart/form-data']) }}
    <div class="article-main">
        <div class="form-group">
            {{ Form::text('title',null, ['class'=>'form-control','required'=>'required','placeholder'=>'专题标题...']) }}
        </div>
        <div class="form-group">
            {{ Form::text('desc',null, ['class'=>'form-control','required'=>'required','placeholder'=>'专题描述...']) }}
        </div>
        <div class="form-group">
            {{ Form::text('accept_email',null, ['class'=>'form-control','required'=>'required', 'placeholder'=>'接收人邮箱地址...']) }}
        </div>
        <div class="form-group">
            {{ Form::date('send_time',null, ['class'=>'form-control', 'placeholder'=>'发送时间...']) }}
        </div>
        <div class="form-group">
            {{ Form::text('article_list',null, ['class'=>'form-control','disabled'=>'','id'=>'articleList','placeholder'=>'文章列表，请在下方勾选']) }}
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit">保存专题</button>
        </div>
    </div>
    <p style="color: red">请先完善以上信息，保存专题再添加文章</p>
    {{ Form::close() }}
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead class="bg-primary">
                <tr>
                    <th>文章id</th>
                    <th>文章id名</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($articles as $article)
                    <tr>
                        <th>{{ $article->id }}</th>
                        <th>{{ $article->title }}</th>
                        <th>
                            @if(in_array($article->id,explode(',',$special->article_list)))
                                <input class="js_article_id" {{$articleDisable?'disabled':''}} data-id="{{ $article->id }}" type="checkbox" onchange="articleChange(this)" checked>
                                @else
                                <input class="js_article_id" {{$articleDisable?'disabled':''}} data-id="{{ $article->id }}" type="checkbox" onchange="articleChange(this)">
                            @endif
                        </th>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">当前还没有文章</td>
                    </tr>
                @endforelse

                </tbody>
            </table>
            <div class="container page_container">
                <nav>
                    {{$articles->render() }}
                </nav>
            </div>

        </div>
    </div>
@endsection

@section('pageScript')
    <script src="//game.gtimg.cn/images/js/devfeed/v2017/ossweb-img/js/jquery.min.js"></script>

    {{--<script src="{{ mix('js/quotas.js') }}"></script>--}}
    <script>
        function articleChange(current) {
            var currentId = $(current).attr('data-id');
            if(current.checked){
                //添加该文章到专题
                var postData = {
                    'type' : 'add',
                    'id' : {{$special->id?$special->id:0}},
                    'article_id' : currentId
                }
            }else{
                //从专题中删除该文章
                var postData = {
                    'type' : 'delete',
                    'id' : {{$special->id?$special->id:0}},
                    'article_id' : currentId
                }
            }
            console.log(postData);
            $.ajax({
                url: "http://fedn1.local/admin/save_article",
                type: "post",
                dataType: "json",
                data:postData,
                timeout: 10000,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $('#articleList').val(data.article_list);
                },
                error: function () {
                }
            });
        }
    </script>
@endsection
