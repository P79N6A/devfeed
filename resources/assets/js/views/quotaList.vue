<template>
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
        <tr v-for="row in rows">
            <td>{{ row.id }}</td>
            <td><a :href="row.url" :title="row.title">{{ row.title }}</a></td>
            <td><a :href="row.site_url" :title="row.site_name">{{ row.site_name }}</a></td>
            <td><a :href="row.author_url" :title="row.author_name">{{ row.author_name }}</a>
            </td>
            <td>{{ row.tags }}</td>
            <td>
                <button class="btn btn-xs btn-success">编辑</button>
                <button class="btn btn-xs btn-warning">发布</button>
                <button class="btn btn-xs btn-danger">删除</button>
            </td>
        </tr>
        </tbody>
    </table>
</template>
<script>
    export default {
        name: 'quotaList',
        data() {
            return {rows: []}
        },
        created() {
            this.$http.post('/api/v1/quotas/list',{size:20}).then((response) => {
              const result = response.data;
              this.rows = result.data.data
            }, (error) => {
              console.log(error)
            })
        }
    }
</script>
