@extends('backend.layout')

@section('pageTitle','角色管理')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">角色管理 <button id="btnCreate" data-toggle="modal" data-target="#formModal" class="btn btn-lg btn-warning">新建角色</button></h1>
        </div>
    </div>

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
                            <button data-id="{{ $role->id }}" class="btn btn-xs btn-success">编辑</button>
                            <button data-id="{{ $role->id }}"
                                    class="btn btn-xs {{ count($role->users)>0 ? 'btn-disabled': 'btn-danger' }}"{{ count($role->users)>0 ? ' disabled': '' }}>
                                删除
                            </button>
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
                        <div class="form-group row">
                            {{ Form::label('title', '角色名称:') }}
                            <div class="col-md-3">{{ Form::text('title',null,['class'=>'form-control']) }}</div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('pageScript')

    <script src="//cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
@endsection