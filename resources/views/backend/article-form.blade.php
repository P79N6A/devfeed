@extends('backend.layout')

@section('pageTitle','添加文章')

@section('extraMeta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('pageStyle')
    <style>
        .category-list, .category-list ul {list-style:none;padding-left:0}
        .category-list li ul {margin-left:15px;}
        .fedn-line {margin-bottom:5px;display:block;padding-bottom:3px;}
        .fedn-label {float:left;margin-right:5px;text-align:right;white-space:nowrap;word-wrap:normal;height:34px;line-height:34px;}
        .fedn-controls {display:block;overflow:hidden}
        .fedn-controls input, select {vertical-align:middle;margin:0;padding:0;height:34px;}
        .fedn-radio, .fedn-checkbox {margin-right:10px;}
        .fedn-controls .tag-wrap {position:relative;padding:3px 5px;cursor:text}
        .tags .tag {
            display:inline-block;
            position:relative;
            border:1px solid #ebebeb;
            background:#eee;
            padding:2px 5px;
            margin-right:3px;
            cursor:pointer;
        }
        #inputTag {
            width:70%;
            display:inline-block;
        }
        .tag-close {
            background:none;
            border:0 none;
            padding:0;
            margin:0;
            line-height:1;
            -webkit-transform:translate(2px, -7px);
            -moz-transform:translate(2px, -7px);
            -ms-transform:translate(2px, -7px);
            -o-transform:translate(2px, -7px);
            transform:translate(2px, -7px);
        }
        .cover-wrap {position:relative;overflow:hidden;display:block;margin:0 auto;width:340px;height:200px;background:rgba(0,0,0,.3);color:#fff;text-align:center;line-height:200px;}
        .fake-cover {position:absolute;top:0;right:0;bottom:0;left:0;opacity:0.7;font-size:400%;z-index:100;}
        #coverPic {width:340px;height:200px;vertical-align:top}
        .article-form {margin-right:-15px;overflow:hidden;}
        .article-ext {float:right;width:402px;margin-left:10px;}
        .article-main {overflow:hidden;}
        #coverFile {
            position:absolute;
            top:-100px;
            left:-100px;
            width:450px;
            height:310px;
            display:block;
            z-index:101;
            cursor:pointer
        }
    </style>
@endsection

@section('content')
    @if(Session::has('errors'))
        <div class="alert alert-danger alert-dismissable fade in">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            @foreach(Session::get('errors')->default->all(':message') as $message)
                <p>{{ $message }}</p>
            @endforeach
        </div>
    @endif
        {{ Form::model($article,['action'=>['Admin\ArticleController@del', $article->id],'class'=>'article-form', 'id'=>'articleForm', 'enctype'=>'multipart/form-data']) }}
        <div class="article-ext">
            <div class="panel panel-default">
                <div class="panel-heading">属性:</div>
                <div class="panel-body">
                    <div class="fedn-line">
                        <span class="fedn-label">状态：</span>
                        <div class="fedn-controls">
                            <label class="fedn-radio">{{ Form::radio('status','draft') }} 草稿</label>
                            <label class="fedn-radio">{{ Form::radio('status','publish') }} 发布</label>
                        </div>
                    </div>
                    <div class="fedn-line">
                        <span class="fedn-label">专题：</span>
                        <div class="fedn-controls">
                            <select name="specials" id="specials">
                                <option value="">专题功能尚未实现</option>
                            </select>
                        </div>
                    </div>
                    <div class="fedn-line">
                        <span class="fedn-label">标签：</span>
                        <div class="fedn-controls">
                            <input id="inputTag" autocomplete="off" type="text" class="form-control">
                            <button type="button" id="btnAddTag" class="btn btn-default">添加</button>
                            <p class="help-block">多个标签用半角逗号分隔</p>
                            <div id="tags" class="tags">
                                @foreach($article->tags as $tag)
                                   <span class="tag">{{ $tag->title }}<button class="tag-close" aria-label="Close">&times;</button></span>
                                @endforeach
                            </div>

                            <input type="hidden" name="tags" value="{{ $article->tags->implode('title',',') }}">
                        </div>
                    </div>
                    <div class="fedn-line">
                        <span class="fedn-label">现有标签：</span>
                        <div class="fedn-controls">
                            @foreach($Tags as $t)
                                <span class="now_tag">{{$t->title}}</span>
                            @endforeach

                            </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">分类:</div>
                <div class="panel-body">
                    <vue-cate-list class="category-list" :categories="categories"></vue-cate-list>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">配图:</div>
                <div class="panel-body">
                    <div class="cover-wrap">
                        <img src="{{ $article->figure }}" alt="" id="coverPic">
                        <span class="fake-cover">点击上传</span>
                        <input type="file" name="figure" id="coverFile">
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">作者:</div>
                <div class="panel-body">
                    <div class="fedn-line">
                        <label class="fedn-label">名称：</label>
                        <div class="fedn-controls">{{ Form::text('author',null, ['class'=>'form-control']) }}</div>
                    </div>
                    <div class="fedn-line">
                        <label class="fedn-label">主页：</label>
                        <div class="fedn-controls">{{ Form::text('author_url',null, ['class'=>'form-control']) }}</div>
                    </div>
                </div>
            </div>

        </div>
        <div class="article-main">
                <div class="form-group">
                    {{ Form::text('title',null, ['class'=>'form-control','placeholder'=>'文章标题...']) }}
                </div>
                <div class="form-group">
                    {{ Form::text('source_url',null, ['class'=>'form-control','placeholder'=>'转载源URL，原创文章请留空...']) }}
                </div>
                <div class="form-group">
                    {{ Form::textarea('summary',null, ['class'=>'form-control', 'placeholder'=>'文章内容摘要...','rows'=>3]) }}
                </div>
                <div class="form-group">
                    <div id="editor">
                        <script id="editorContainer" name="content" type="text/plain">
                            {!!  $article->content or '' !!}
                        </script>
                    </div>
                </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">保存文章</button>
            </div>

        </div>

        {{ Form::close() }}
@endsection

@section('pageScript')
    <script src="//cdn.bootcss.com/jquery/2.2.4/jquery.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="//cdn.bootcss.com/vue/1.0.25/vue.min.js"></script>
    <script src="//cdn.bootcss.com/vue-resource/0.8.0/vue-resource.min.js"></script>
    <script src="{{ asset('ueditor/ueditor.config.js') }}"></script>
    <script src="{{ asset('ueditor/ueditor.all.js') }}"></script>
    <template id="vueCateList">
        <ul>
            <li v-for="item in categories">
                <input name="categories[]" type="checkbox" v-model="checkedIds" :value="item.id"> @{{ item.title }}
                <vue-cate-list v-if="item.children" :categories="item.children"></vue-cate-list>
            </li>
        </ul>
    </template>
    <script>
        (function($){
            "use strict";
            const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
            let tags = [];
            Vue.component('vueCateList', {
                template: '#vueCateList',
                props: ['categories'],
                data: function () {
                    return {
                        checkedIds: this.$parent.checkedIds
                    }
                }
            });
            const vm = new Vue({
                el: '#articleForm',
                data: {
                    checkedIds: {{ json_encode($article->categories->modelKeys()) }}
                },
                ready: function () {
                    this.$http.get("{{ route('api.category.list') }}").then(function (response) {
                        this.$set('categories', response.data);
                    });
                }
            });
            const onCoverChanged = function() {
                let $coverFile = document.getElementById('coverFile').files[0];
                if($coverFile) {
                    let dataUri = window.URL.createObjectURL($coverFile);
                    $('#coverPic').attr('src', dataUri).show();
                }
            };
            const makeTag = function(tag) {
                let btn = document.createElement('button');
                btn.textContent = '×';
                btn.className = "tag-close";
                btn.setAttribute('aria-label','Close');
                let tagSpan = document.createElement('span');
                tagSpan.className = "tag";

                tagSpan.textContent = tag;
                tagSpan.appendChild(btn);
                return tagSpan;
            };
            const onReady = function () {
                var editor = UE.getEditor('editorContainer',{
                    toolbars: [
                        [
                            'source', '|', 'undo', 'redo', '|',
                            'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', '|',
                            'indent', '|',
                            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                            'simpleupload', 'insertimage', 'insertcode'

                        ],
                        [
                            'paragraph', 'fontsize', 'removeformat', 'formatmatch', 'autotypeset', 'horizontal','wordimage','inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
                            'searchreplace', 'insertvideo', 'music', 'attachment', 'map', 'gmap', '|', 'pagebreak'
                        ]
                    ],
                    initialFrameHeight:652,
                    saveInterval: 2000,
                    retainOnlyLabelPasted: true,
                    autoHeightEnabled: false,
                    pageBreakTag: '<!--more-->',
                    maximumWords: 50000
                });
                $('#articleForm').on('change', '#coverFile', onCoverChanged);
                $('#articleForm').on('click', '#btnAddTag', function(){
                    let _tags = $('#inputTag').val();
                    if(!_tags){
                        return false;
                    }
                    _tags = _tags.split(',');
                    _tags.map(function(tag){
                        if(tag.trim() === ''){
                            return false;
                        }
                        let tagSpan = makeTag(tag);
                        $('#tags')[0].appendChild(tagSpan);
                        $('input[name=tags]')[0].value += ','+tag;
                    });
                    $(this).val('').blur();
                });
                $('#articleForm').on('click', '.now_tag', function(){
                    console.info($(this).text())
                    var tag = $(this).text();
                    $('#tags')[0].appendChild(makeTag(tag));
                    $('input[name=tags]')[0].value += ','+tag;
                });
                $('#articleForm').on('click', '.tag', function(){
                    let tag = this.textContent.replace('×', '');
                    $(this).remove();
                    $('input[name=tags]')[0].value = $('input[name=tags]')[0].value.replace(tag,'');
                });



            };
            $(onReady);
        }(jQuery))
    </script>
@endsection