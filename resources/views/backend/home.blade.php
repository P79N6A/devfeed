@extends('backend.layout')

@section('pageStyle')
<style>
    .content {
        min-height: 250px;
        padding: 15px;
        margin-right: auto;
        margin-left: auto;
        padding-left: 15px;
        padding-right: 15px;

    }

    .box {
        position: relative;
        border-radius: 3px;

        border-top: 3px solid #d2d6de;
        margin-bottom: 20px;
        width: 100%;
    }
    .no-padding {padding:0 !important;}

    .box-body {
        padding: 10px;

    }
    .box-body .table {
        background: #ecf0f5;
    }
    .box-body th {
        text-align:right;
        padding-right:1em;
    }
    .box-body .text-center {
        text-align:center;
    }
</style>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            系统信息
            <small>系统基础信息</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th colspan="2" class="text-center">系统数据</th>
                            </tr>
                            <tr>
                                <th>文章数</th>
                                <td>{{ $aCount }}</td>
                            </tr>
                            <tr>
                                <th>待审稿件数</th>
                                <td>{{ $qCount }}</td>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-center">服务器环境</th>
                            </tr>
                            <tr>
                                <th>操作系统</th>
                                <td>{{  php_uname() }}</td>
                            </tr>
                            <tr>
                                <th>PHP 版本</th>
                                <td>{{ PHP_VERSION }}</td>
                            </tr>
                            <tr>
                                <th>PHP 运行方式</th>
                                <td>{{ php_sapi_name() }}</td>
                            </tr>
                            <tr>
                                <th>Zend 版本</th>
                                <td>{{ Zend_Version() }}</td>
                            </tr>
                            <tr>
                                <th>Laravel 版本</th>
                                <td>{{ app()::VERSION }}</td>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-center">网站环境</th>
                            </tr>
                            <tr>
                                <th>域名</th>
                                <td>{{ env('HTTP_HOST', 'fedn.it') }}</td>
                            </tr>
                            <tr>
                                <th>服务器IP</th>
                                <td>{{ env('SERVER_ADDR', gethostbyname(env('SERVER_NAME'))) }}</td>
                            </tr>
                            <tr>
                                <th>请求路径</th>
                                <td>{{ env('REQUEST_URI') }}</td>
                            <tr>
                                <th>网站根目录</th>
                                <td>{{ env('DOCUMENT_ROOT') }}</td>
                            </tr>
                            <tr>
                                <th>请求路径</th>
                                <td>{{ env('REQUEST_URI') }}</td>
                            </tr>
                            <tr>
                                <th>路由名称</th>
                                <td>{{ Route::currentRouteName() }}</td>
                            </tr>
                            <tr>
                                <th>控制器</th>
                                <td>{{ Route::currentRouteAction() }}</td>
                            </tr>
                            <tr>
                                <th>视图路径</th>
                                <td>{{ $viewPath }}</td>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-center">性能数据</th>
                            </tr>
                            <tr>
                                <th>响应时间：</th>
                                <td>{{ round(microtime(true) - LARAVEL_START, 2) }}秒</td>
                            </tr>
                            <tr>
                                <th>内存占用：</th>
                                <td>@php
                                    $size = memory_get_usage(false);
                                    $unit = ['b', 'K', 'M', 'G', 'T', 'P'];
                                    echo round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
                                    @endphp</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
