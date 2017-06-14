@extends('backend.layout')

@section('content')
    <h3 class="page-header">团队管理</h3>
    <div id="teamApp">
        <router-view></router-view>
    </div>
@endsection

@section('pageScript')
    <script src="//cdn.bootcss.com/jquery/1.12.4/jquery.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdn.bootcss.com/axios/0.16.2/axios.js"></script>
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/team.js') }}"></script>
@endsection
