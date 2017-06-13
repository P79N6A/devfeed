@extends('backend.layout')

@section('content')
    <h3 class="page-header">团队管理</h3>
    <div id="teamApp">
        <router-view></router-view>

    </div>
@endsection

@section('pageScript')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/team.js') }}"></script>\
@endsection
