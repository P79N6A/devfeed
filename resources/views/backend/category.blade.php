@extends('backend.layout')

@section('pageTitle','分类管理')

@section('extraMeta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="row" id="app">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">添加分类</h3>
                </div>
                <div class="panel-body">
                    <form>
                        <div class="form-group">
                            <label for="title">名称</label>
                            <input type="text" class="form-control" id="title" v-model="category.title" placeholder="分类名称">
                        </div>
                        <div class="form-group">
                            <label for="slug">别名</label>
                            <input type="text" class="form-control" id="title" v-model="category.slug" placeholder="用于URL的Slug">
                            <p class="help-block">别名用于URL，只能包含小写字母、数字和连字符（-）</p>
                        </div>
                        <div class="form-group">
                            <label for="parent_id">所属分类</label>
                            <select id="parentId" name="parent_id" v-model="category.parent_id" class="form-control">
                                <option value="0">作为顶级分类</option>
                                <option is="vue-option" v-for="cate in categories" :item="cate"></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">描述</label>
                            <textarea class="form-control" v-model="category.description" id="description" placeholder="分类描述"></textarea>
                        </div>

                        <button type="button" class="btn btn-default" @click="saveCategory">保存</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <table class="table table-striped">
                <thead class="bg-primary">
                <tr>
                    <th style="width:15px"><input type="checkbox" id="cbAll"></th>
                    <th>名称</th>
                    <th>描述</th>
                    <th>别名</th>
                    <th>文章数</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <button class="btn btn-danger" @click="delCategories">删除选中分类</button>
                        <p class="help-block">注：删除分类不会删除该分类下的文章</p></td>
                </tr
                </tfoot>
                <tbody>
                <tr is="vue-tr" v-for="cate in categories" :item="cate"></tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('pageScript')
    <template id="vueTr">
        <tr>
            <td><input type="checkbox" v-model="checkedIds" :value="item.id"></td>
            <td>@{{ item.depth | repeat "--" }}@{{ item.title }}</td>
            <td>@{{ item.description }}</td>
            <td>@{{ item.slug }}</td>
            <td>@{{ item.count }}</td>
        </tr>
        <tr is="vue-tr" v-for="cate in item.children" :item="cate"></tr>
    </template>
    <template id="vueOption">
        <option :value="item.id">@{{ item.depth | repeat "&nbsp;&nbsp;&nbsp;&nbsp;" }}@{{ item.title }}</option>
        <option is="vue-option" v-for="cate in item.children" :item="cate"></option>
    </template>

    <script src="http://cdn.bootcss.com/vue/1.0.25/vue.min.js"></script>
    <script src="http://cdn.bootcss.com/vue-resource/0.8.0/vue-resource.min.js"></script>
    <script>
        "use strict";
        const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
        Vue.config.devTools = true;
        Vue.component('vue-tr', {
            template: '#vueTr',
            props: ['item'],
            data: function () {
                return {
                    checkedIds: this.$parent.checkedIds
                }
            }
        });
        Vue.component('vue-option', {
            template: '#vueOption',
            props: ['item']
        });
        Vue.filter('repeat', function (count, str) {
            return str.repeat(count);
        });
        const vm = new Vue({
            el: '#app',
            data: {
                category: {
                    parent_id: 0
                },
                categories: [],
                checkedIds: []
            },
            methods: {
                listCategories: function () {
                    this.$http.get("{{ route('api.category.list') }}").then(function (response) {
                        this.$set('categories', response.data)
                    });
                },
                update: function (response) {
                    if (response.ok) {
                        this.listCategories();
                        this.$set('category', null);
                        this.$set('checkedIds', []);
                    }
                },
                saveCategory: function () {
                    const _this = this;
                    this.$http.post("{{ route('api.category.save') }}", this.$get('category'), {"headers": {"X-CSRF-TOKEN": token}})
                        .then(this.update, function (response) {
                            alert('出错了，具体错误请看 DevTools 的 Console 信息');
                            console.log(response.data);
                        });
                },
                delCategories: function () {
                    if (confirm('确定要删除选中的分类的吗？')) {
                        this.$http.delete("{{ route('api.category.delete') }}", {"ids":this.$get('checkedIds')}, {"headers": {"X-CSRF-TOKEN": token}})
                            .then(this.update, function (response) {
                                alert('出错了，具体错误请看 DevTools 的 Console 信息');
                                console.log(response.data);
                            });
                    }
                }
            },
            ready: function () {
                this.listCategories();
            }
        });
    </script>
@endsection