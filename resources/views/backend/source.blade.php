@extends('backend.layout')

@section('pageTitle', '源站管理')

@section('content')
    <h1 class="page-header">采集管理</h1>

    <div class="row">
        <div class="col-md-12" id="sourceApp"></div>
    </div>
@endsection

@section('pageScript')
    @include('backend.partial.vue-foot')
    <script src="{{ mix('js/source.js') }}"></script>
@endsection
