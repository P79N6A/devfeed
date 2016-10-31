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
                    <th>标题</th>
                    <th>类型</th>
                    <th>作者</th>
                    <th>分类</th>
                    <th>标签</th>
                    <th>评论</th>
                    <th>日期</th>
                    <th>录入</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($articles as $art)
                    <tr>

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
                                <a href="{{'/tag/'.$tag->id}}" target="_blank">{{ $tag->title }}</a>
                            @endforeach
                        </td>
                        <td>{{ count($art->comments) }}</td>
                        <td>@if($art->status == 'draft')
                                     <span style="color:red">草稿</span>
                                @elseif($art->status == 'publish')
                                     已发布
                                @else
                                {{ $art->status }}
                                @endif
                            <span style="color: #666666;font-size: 12px">({{ $art->created_at }})</span>
                            <br>修改时间：  <span style="color: #666666;font-size: 12px">({{ $art->updated_at }})</span></td>
                        <td>{{ $art->user->name }}</td>
                        <td><button data-id="{{$art->id}}" class="btn btn-small btn-default btn-delete">删除</button>
                            @if($art->status == 'draft')
                                    <button class="btn btn-small btn-primary btn-publish" data-id="{{$art->id}}">发布
                            @endif
                        </td>
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
<script src="//cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>

<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}});
    $(function () {
        var id, _this;
        $(".btn-publish").on('click', function () {
            id = $(this).data("id");
            _this = $(this).closest('tr');
            $.ajax({
                url: '/admin/article/publish/'+id,
                type: 'POST',
                data: {},
                dataType: 'json',
                success: function (data) {
                    if (data) {
                        alert('发布成功！');
                        location.reload();
                    }
                }
            });

        });
        $(".btn-delete").on('click', function(){
            id = $(this).data('id');
            _this = $(this).closest('tr');
            var msg = "您真的确定要删除吗？\n\n请确认！";
            if (confirm(msg) == true) {
                $.ajax({
                    url: '/admin/article/'+id,
                    type: 'DELETE',
                    data: {},
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            alert('删除成功！');
                            location.reload();
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
