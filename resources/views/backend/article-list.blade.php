@extends('backend.layout')

@section('pageTitle', '文章管理')

@section('content')
    <h1 class="page-header">文章管理</h1>

    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('admin.article.add') }}" class="btn btn-success">添加文章</a>
        </div>
        <div class="col-md-6">

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead class="bg-primary">
                <tr>
                    <td id="cb"><input type="checkbox" id="cbSelectAll"></td>
                    <th>标题</th>
                    <th>类型</th>
                    <th>作者</th>
                    <th>分类</th>
                    <th>标签</th>
                    <th>评论</th>
                    <th>日期</th>
                    <th>录入</th>
                </tr>
                </thead>
                <tbody>
                @forelse($articles as $art)
                    <tr>
                        <td><input id="ckb-{{$art->id}}" type="checkbox" value="{{ $art->id }}"></td>
                        <td>{{ Html::Link('admin/article/'.$art->id, $art->title) }}</td>
                        <td>{{ $art->isLink ? '转载': '原创' }}</td>
                        <td>{{ $art->author }}</td>
                        <td>
                            @foreach($art->categories as $cate)
                                <a href="javascript:alert('尚未实现')">{{ $cate->title }}</a>
                            @endforeach
                        </td>
                        <td>
                            @foreach($art->tags as $tag)
                                <a href="javascript:alert('尚未实现')">{{ $tag->title }}</a>
                            @endforeach
                        </td>
                        <td>{{ count($art->comments) }}</td>
                        <td>{{ $art->status }} <br> {{ $art->updated_at }}</td>
                        <td>{{ $art->user->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">当前还没有文章</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection