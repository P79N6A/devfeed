@extends('backend.layout')

@section('content')
    <h3 class="page-header">团队管理</h3>
    <div class="row col-md-12" id="teamApp">

    </div>
@endsection

@section('pageScript')
  {{ Html::script('/js/vue.min.js') }}
  {{ Html::script('/js/team.js') }}
@endsection
