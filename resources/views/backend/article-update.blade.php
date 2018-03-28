@extends('backend.layout')

@section('pageTitle', '文章更新')

@section('content')
    <h1 class="page-header">文章更新</h1>

    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('admin.remote.update') }}" class="btn btn-success">继续更新</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3 class="title">本次完成更新的文章</h3>
            <table class="table table-bordered">
                <thead class="bg-primary">
                <tr>
                    <th>标题</th>
                    <th>图片数</th>
                </tr>
                </thead>
                <tbody>
                @forelse($updated as $art)
                    <tr>

                        <td>{{ Html::Link('article/'.$art->id, $art->title, ['target'=>"_blank"]) }}</td>
                        <td>{{ $art->remoteFiles()->count() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">没有</td>
                    </tr>
                @endforelse

                </tbody>
            </table>

            <h3 class="title">本次跳过的文章</h3>
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead class="bg-primary">
                    <tr>
                        <th>标题</th>
                        <th>图片数</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($skipped as $art)
                        <tr>

                            <td>{{ Html::Link('article/'.$art->id, $art->title, ['target'=>"_blank"]) }}</td>
                            <td>N/A</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">没有</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
        </div>
    </div>
@endsection
