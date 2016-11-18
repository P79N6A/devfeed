@extends('backend.layout')

@section('pageTitle', '采集管理')

@section('content')
    <h1 class="page-header">采集管理</h1>

    <div class="row">
        <div class="col-md-12" id="quotaApp">
            <quota-list></quota-list>
            <div class="container page_container">
                <nav>
                    <ul class="pagination pull-right">

                    </ul>
                </nav>
            </div>

        </div>
    </div>
@endsection

@section('pageScript')

    {{ Html::script('/js/vue.min.js') }}
    {{ Html::script('/js/quotas.js') }}
@endsection
