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
                <button @click="publish(row.id)" class="btn btn-xs btn-warning">发布</button>
                <button @click="del(row.id)" class="btn btn-xs btn-danger">删除</button>
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
        methods: {
          publish(id) {
            const self = this;
            if(confirm('确定要发布这篇文章吗？')) {
                self.$http.post('/api/v1/quotas/publish/'+id).then(() => {
                  self.fetch();
                }, x => {
                  console.log(x.data);
                })
            }
          },
          del(id) {
            const self = this;
            if(confirm('确定要删除这篇文章吗？')) {
                self.$http.post('/api/v1/quotas/del/'+id).then(() => {
                  self.fetch();
                }, x => {
                  console.log(x.data);
                })
            }
          },
          fetch() {
            const self = this;
            self.$http.post('/api/v1/quotas/list',{size:20}).then(res => {
              const result = res.data;
              self.rows = result.data.data
            }, x => {
              console.log(x.data);
            })
          }
        },
        created() {
            this.fetch();
        }
    }
</script>
