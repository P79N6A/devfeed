@extends('backend.layout')

@section('content')
    {{ Form::model($category,['url'=>'admin/category/save']) }}

    {{ Form::close() }}
@endsection