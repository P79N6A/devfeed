@extends('backend.layout')

@section('content')
    <div id="teamApp">
        <h3 class="page-header">团队管理
            <button class="btn btn-success btn-lg" @click.prevent="addTeam">新建团队</button>
        </h3>
        <router-view></router-view>
    </div>
@endsection

@section('pageScript')
    @include('backend.partial.vue-foot')
    <script src="{{ mix('js/team.js') }}"></script>
@endsection
