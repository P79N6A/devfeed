@extends('backend.layout')

@section('pageTitle','角色管理')

@section('content')
<div id="app">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">用户管理
                {{--<button id="btnCreate" data-toggle="modal" data-target="#formModal" class="btn btn-primary">新建用户
                </button>--}}
            </h1>
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
            <user-table :users="users"></user-table>
        </div>
    </div>
    <role-modal id="roleModal" :userroles="selectedRoles"></role-modal>
</div>
@endsection

@section('pageScript')
    <script type="text/x-template" id="modal">
        <div class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header drag">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">用户角色管理</h4>
                    </div>
                    <div class="modal-body">
                        <form id="saveForm" class="form-horizontal">
                            {{ csrf_field() }}
                            <div class="checkbox" v-for="role in roles">
                                <label>
                                    <input name="roles[]" type="checkbox" :value="role.id" v-model="newRoles"> @{{role.description}}
                                </label>
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
    </script>

    <script type="text/x-template" id="userTable">
        <table class="table table-bordered">
            <thead class="bg-primary">
            <tr>
                <th>ID</th>
                <th>用户名</th>
                <th>角色</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="(user,index) in users">
                    <td>@{{ user.id }}</td>
                    <td>@{{ user.name }}</td>
                    <td><span style="margin-right:5px" v-for="role in user.roles">@{{ role.description }}</span></td>
                    <td><button :data-index="index" data-target="#roleModal" data-toggle="modal" class="btn btn-xs btn-success">设置角色</button></td>
                </tr>
            </tbody>
        </table>
    </script>
    <script src="//cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdn.bootcss.com/vue/2.3.0/vue.js"></script>
    <script>
        var jq = jQuery.noConflict();
        var currentRoles = [];
        Vue.component('user-table', {
           template: "#userTable",
           props:[ 'users' ]
        });
        var modal = Vue.component('role-modal', {
            template: '#modal',
            props:[ 'userroles'],
            data: function(){
                return {
                    roles: [
                        {id: 1, title: 'Admin', description:'系统管理员'},
                        {id: 2, title: 'Webmaster', description: '网站管理员'},
                        {id: 3, title: 'Moderator', description: '内容管理员'},
                        {id: 4, title: 'Contributor', description: '投稿者'},
                        {id: 5, title: 'Subscriber', description: '订阅者'}
                    ]
                }
            },
            computed: {
                newRoles: function(){
                    return this.userroles;
                }
            },
            methods: {
                changed: function(){
                    this.$emit('changed');
                }
            }
        });

        var vm = new Vue({
            data: {
                users: [],
                selectedRoles:[]
            },
            mounted: function() {
              this.getUsers();
            },
            methods: {
                getUsers: function(){
                    var that = this;
                    jq.getJSON('{{route('admin.user.list')}}', function(data){
                        that.users = data;
                    });
                }
            }
        }).$mount('#app');

        jq('#roleModal').on('show.bs.modal', function (event) {
            vm.selectedRoles = [];
            var button = jq(event.relatedTarget);
            var index = button.data('index');
            var user = vm.users[index];
            if (user) {
                var form = jq("#saveForm");
                form.append('<input type="hidden" name="id" value="' + user.id + '">');
                var _roles = [];
                for(var i = 0, role; role = user.roles[i];i++) {
                    _roles.push(role.id);
                }
                vm.selectedRoles = _roles;
            }
            jq(document).one('click', '#btnSaveRole', function(){
                var data = jq('#saveForm').serialize();
                jq.post("{{ route('admin.user.save') }}", data, function(result){
                    location.reload(true);
                })
            });
        });
        jq('#roleModal').on('hide.bs.modal', function (event) {
            jq('input[name=id]', '#saveForm').remove();
            vm.selectedRoles = [];
        });
    </script>
@endsection
