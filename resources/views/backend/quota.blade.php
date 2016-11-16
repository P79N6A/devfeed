@extends('backend.layout')

@section('pageTitle', '采集管理')

@section('content')
    <h1 class="page-header">采集管理</h1>

    <div class="row">
        <div class="col-md-12" id="quotaApp">
            <table class="table table-bordered">
                <thead class="bg-primary">
                <tr>
                    <th>ID</th>
                    <th>标题</th>
                    <th>站点</th>
                    <th>作者</th>
                    <th>标签</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in rows">
                    <td>@{{ item.id }}</td>
                    <td><a :href="item.url" :title="item.title">@{{ item.title }}</a></td>
                    <td><a :href="item.site_url" :title="item.site_name">@{{ item.site_name }}</a></td>
                    <td><a :href="item.author_url" :title="item.author_name">@{{ item.author_name }}</a>
                    </td>
                    <td>@{{ item.tags }}</td>
                    <td>
                        <button class="btn btn-xs btn-success">编辑</button>
                        <button class="btn btn-xs btn-warning">发布</button>
                        <button class="btn btn-xs btn-danger">删除</button>
                    </td>
                </tr>
                </tbody>
            </table>

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
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <script src="http://cdn.bootcss.com/vue-resource/1.0.3/vue-resource.js"></script>
    <script>
        const api = '{{ route('api.quota.list') }}'
        var app = new Vue({
          el: '#quotaApp',
          data: {
            currentPage: 1,
            rows: []
          },
          created: function () {
            var data = {d: (new Date()).getTime(), page: this.currentPage}
            this.$http.get(api, data).then(function (response) {
              //look into the routes file and format your response
              //this.pagination = response.pagination
              this.rows = response.data.data
            }, function (error) {
              // handle error
            })
          }
        })
    </script>
@endsection
