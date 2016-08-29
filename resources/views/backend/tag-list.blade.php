@extends('backend.layout')

@section('pageTitle', '标签')

@section('content')
    <h1 class="page-header">标签管理</h1>

    <div class="row">
        <div class="col-md-6">
            <a href="{{ url('admin/tag') }}" class="btn btn-success">新建标签</a>
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
                    <th>图片</th>
                    <th>slug</th>
                    <th>标题</th>
                    <th>描述</th>
                    <th>文章数</th>
                    <th>创建日期</th>
                </tr>
                </thead>
                <tbody>
                @forelse($tags as $tag)
                    <tr>
                        <td><input id="ckb-{{$tag->id}}" type="checkbox" value="{{ $tag->id }}"></td>
                        <td><img src="{{ $tag->figure  }}" width="80" height="80"></td>
                        <td>{{ $tag->slug }}</td>
                        <td>{{ Html::Link('admin/tag/'.$tag->id, $tag->title) }}</td>
                        <td>{{ $tag->description }}</td>
                        <td>{{ $tag->articles_count }}</td>
                        <td>{{ $tag->created_at }}
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">当前还没有标签</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $tags->links() }}
        </div>
    </div>
@endsection