@extends('backend.layout')

@section('pageTitle','添加文章')

@section('extraMeta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('editor/css/editormd.min.css') }}">
    <style>
        .article-main {border-right:1px solid #ccc;}
    </style>
@endsection

@section('content')
        {{ Form::model($article,['class'=>'row']) }}
        <div class="col-sm-10 col-md-9 article-main">
                <div class="form-group">
                    <label for="">文章标题</label>
                    <input type="text" class="form-control" placeholder="文章标题...">
                </div>
                <div class="form-group">
                    <label for="">Slug</label>
                    <input type="text" class="form-control" placeholder="文章标题...">
                </div>
                <div class="form-group">
                    <label for="">导读/摘要</label>
                    <textarea name="summary" id="summary" class="form-control" placeholder="文章内容摘要..."></textarea>
                </div>
                <div class="form-group">
                    <label for="">正文</label>
                    <div id="editor">
                        {{ Form::textarea('content', null, ['class'=>'form-control','id'=>'content']) }}
                    </div>
                </div>

        </div>
        <div class="col-sm-2 col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">分类:</div>
                <div class="panel-body">
                    <ul>
                        <li><input type="checkbox"><label for="">Cate 1</label></li>
                        <li><input type="checkbox"><label for="">Cate 2</label></li>
                        <li><input type="checkbox"><label for="">Cate 3</label></li>
                    </ul>

                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">作者:</div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="author" class="col-md-3 control-label">名称</label>
                            <div class="col-md-9"><input type="text" class="form-control"></div>
                        </div>
                        <div class="form-group">
                            <label for="author" class="col-md-3 control-label">主页</label>
                            <div class="col-md-9"><input type="text" class="form-control"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{ Form::close() }}
@endsection

@section('pageScript')
    <script src="//cdn.bootcss.com/jquery/2.2.4/jquery.js"></script>
    <script src="{{ asset('editor/editormd.min.js') }}"></script>
    <script>
        (function($){
            "use strict";
            const onReady = function() {
                const editor = editormd("editor",{
                    path : "/editor/lib/",
                    toolbarIcons: [
                        "undo", "redo", "|",
                        "bold", "italic", "quote", "code", "code-block", "|",
                        "h1", "h2", "h3", "h4", "h5", "h6", "|",
                        "list-ul", "list-ol", "hr", "|",
                        "link", "reference-link", "image", "table", "|",
                        "watch", "fullscreen", "|" , "help"
                    ],
                    gotoLine: false,
                    indentWithTabs: false,
                    saveHTMLToTextarea: false,
                    imageUpload:true,
                    tocm: true,
                    pageBreak: false,
                    flowChart: true,
                    lineNumbers: false,
                    watch:false,
                    placeholder: "文章内容,请使用 Markdown 语法...",
                    styleActiveLine: false,
                    dialogMaskBgColor: "#000"

                });
            };
            $(onReady);
        }(jQuery))
    </script>
@endsection