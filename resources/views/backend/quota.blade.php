@extends('backend.layout')

@section('pageTitle', '采集管理')

@section('content')
    <h1 class="page-header">采集管理</h1>

    <div class="row">
        <div class="col-md-12" id="quotaApp">
            <quota-list></quota-list>
        </div>
    </div>
@endsection

@section('pageScript')
    @include('backend.partial.vue-foot')
    <script src="{{ mix('js/quotas.js') }}"></script>
@endsection
