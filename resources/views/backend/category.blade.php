@extends('backend.layout')

@section('pageTitle','分类管理')

@section('content')
<h1 class="page-header">分类管理</h1>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">添加分类</h3>
            </div>
            <div class="panel-body">
                <form>
                    <div class="form-group">
                        <label for="title">名称</label>
                        <input type="text" class="form-control" id="title" placeholder="分类名称">
                    </div>
                    <div class="form-group">
                        <label for="slug">别名</label>
                        <input type="text" class="form-control" id="title" placeholder="用于URL的Slug">
                        <p class="help-block">别名用于URL，只能包含小写字母、数字和连字符（-）</p>
                    </div>
                    <div class="form-group">
                        <label for="parent_id">所属分类</label>
                        <select id="parentId" name="parent_id" class="form-control">
                            <option value="0">作为顶级分类</option>
                            @foreach($categories as $cate)
                                @include('backend.loops.category-option', ['item'=>$cate])
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">描述</label>
                        <textarea class="form-control" id="description" placeholder="分类描述"></textarea>
                    </div>

                    <button type="submit" class="btn btn-default">保存</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <table class="table table-striped">
            <thead class="bg-primary">
            <tr>
                <th style="width:15px"><input type="checkbox" id="cbAll"></th>
                <th>名称</th>
                <th>描述</th>
                <th>别名</th>
                <th>文章数</th>
            </tr>
            </thead>
            <tfoot>
            <tr><td colspan="5"><button class="btn btn-danger">删除选中分类</button><p class="help-block">注：删除分类不会删除该分类下的文章</p></td></tr>
            </tfoot>
            <tbody>
            @forelse($categories as $cate)
                @include('backend.loops.category-tr', ['item'=>$cate])
            @empty
            <tr><td colspan="5">系统中暂时没有分类</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
