<template>
    <div>
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
        <tr v-for="row in result.data">
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
    <ul v-show="result.total > 1" class="pagination">
        <li v-if="result.prev_page_url"><a href="#" @click.prevent="fetch(result.current_page-1)" rel="prev">上一页</a></li>
        <li v-else class="disabled"><span>上一页</span></li>
        <li class="disabled"><span>{{ result.current_page }} / {{ parseInt(result.total / result.per_page) - 1 }}</span></li>
        <li v-if="result.next_page_url"><a href="#" @click.prevent="fetch(result.current_page+1)" rel="next">下一页</a></li>
        <li v-else class="disabled"><span>下一页</span></li>
    </ul>
    </div>
</template>
<script>
    export default {
        name: 'quotaList',
        data() {
            return { result:{} }
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
          fetch(page) {
            page = ('undefined' === typeof page || isNaN(page) )? 1 : page;
            const self = this;
            self.$http.post('/api/v1/quotas/list',{"size":20, "page":page}).then(res => {
              const result = res.data;
              self.result = result.data
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
