@extends('backend.layout')

@section('pageTitle','分类管理')

@section('content')
<h1 class="page-header">分类管理 <a href="{{ url('admin/category/create') }}" data-toggle="modal" data-target="#categoryModal" class="btn btn-primary">新建分类</a></h1>
@endsection
