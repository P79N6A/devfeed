@extends('backend.layout')

@section('pageTitle','角色管理')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">角色管理 <button id="btnCreate" data-toggle="modal" data-target="#formModal" class="btn btn-primary">新建角色</button></h1>
        </div>
    </div>
    @if(session('message'))
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <p class="alert alert-{{ session('message')['type'] }} alert-dismissable fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('message')['text'] }}
                </p>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <table class="table table-bordered">
                <thead class="bg-primary">
                <tr>
                    <th>ID</th>
                    <th>角色</th>
                    <th>用户数</th>
                    <th>说明</th>
                    <th>操作</th>
                </tr>
                </thead>
                @if($roles->hasMorePages())
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <nav>
                                {!! $roles->links() !!}
                            </nav>
                        </td>
                    </tr>
                    </tfoot>

                @endif
                <tbody>
                @forelse($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->title }}</td>
                        <td>{{ $role->users()->count() }}</td>
                        <td>{{ $role->description }}</td>
                        <td>
                            <button data-id="{{ $role->id }}" data-title="{{ $role->title }}" data-description="{{ $role->description }}" data-toggle="modal" data-target="#formModal" class="btn btn-xs btn-success">编辑</button>
                            <a href="{{ route('admin.role.del', $role->id) }}" class="btn btn-xs btn-danger{{ count($role->users)>0 ? ' btn-disabled': '' }}"{!! count($role->users)>0 ? ' disabled onclick="return false;"': ' onclick="return confirm(\'确定要删除角色吗?\');"' !!}>删除</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">系统中还没有任何角色。</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="formModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header drag">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">新建角色</h4>
                </div>
                <div class="modal-body">
                    <form id="saveForm" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            {{ Form::label('title', '角色名称',['class'=>'control-label col-md-2']) }}
                            <div class="col-md-10">{{ Form::text('title',null,['class'=>'form-control']) }}</div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('description', '角色描述',['class'=>'control-label col-md-2']) }}
                            <div class="col-md-10">{{ Form::text('description',null,['class'=>'form-control']) }}</div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button id="btnSaveRole" type="button" class="btn btn-primary">保存</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('pageScript')
<script src="//cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script>
    (function($) {
        "use strict";
        function saveRole(event) {
            var data = $('#saveForm').serialize();

            event.preventDefault();
            event.stopPropagation();

            var xhr = $.post('{{ route('admin.role.save') }}', data,
                             function (result, status) {
                                 if (status === 'success') {
                                     location.reload(true);
                                 } else {
                                     alert(result.message);
                                 }
                             });
            xhr.fail(function(xhr){
                alert(xhr.responseJSON.message);
            });
        }
        $('#formModal').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var data = null;
            if(id && isNaN(id) === false) {
                var form = $("#saveForm");
                form.append('<input type="hidden" name="id" value="'+ id +'">');
                form.find('input[name=title]').val(button.data('title'));
                form.find('input[name=description]').val(button.data('description'));
            }
            $(document).one('click', '#btnSaveRole', saveRole);
        });
        $('#formModal').on('hide.bs.modal', function(event){
           $('input[name=id]', '#saveForm').remove();
        });

    })(jQuery);
</script>
@endsection