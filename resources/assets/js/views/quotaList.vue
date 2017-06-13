<template>
    <div>
    <div class="alert alert-dismissible" :class="{ 'alert-success': status, 'alert-danger': !status }" role="alert" v-show="msg">
        <button type="button" class="close" @click.prevent="closeAlert()">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        <strong>{{ msg }}</strong>
    </div>
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
        <tr v-for="(row, index) in result.data">
            <td>{{ row.id }}</td>
            <td><a :href="row.url" :title="row.title">{{ row.title }}</a></td>
            <td><a :href="row.site_url" :title="row.site_name">{{ row.site_name }}</a></td>
            <td><a :href="row.author_url" :title="row.author_name">{{ row.author_name }}</a>
            </td>
            <td>{{ row.tags }}</td>
            <td>
                <button @click="publish(index)" class="btn btn-xs btn-warning" v-bind:disabled="row.onqueue">发布</button>
                <button @click="del(index)" class="btn btn-xs btn-danger">删除</button>
            </td>
        </tr>
        </tbody>
    </table>
    <ul v-show="result.total > 1" class="pagination">
        <li v-if="result.prev_page_url"><a href="#" @click.prevent="fetch(result.current_page-1)" rel="prev">上一页</a></li>
        <li v-else class="disabled"><span>上一页</span></li>
        <li class="disabled"><span>{{ result.current_page }} / {{ parseInt(result.total / result.per_page) + 1 }}</span></li>
        <li v-if="result.next_page_url"><a href="#" @click.prevent="fetch(result.current_page+1)" rel="next">下一页</a></li>
        <li v-else class="disabled"><span>下一页</span></li>
    </ul>
    </div>
</template>
<script>
    export default {
        name: 'quotaList',
        data() {
            return { result:{}, msg:'', status:true }
        },
        methods: {
          closeAlert() {
            this.msg = false;
            this.status = true;
          },
          publish(index) {
            const self = this;
            if(confirm('确定要发布这篇文章吗？')) {
                const item = self.result.data[index];
                self.$set(self.result.data[index], 'onqueue', true);
                self.result.data[index] = item;
                axios.post('/api/v1/quotas/publish/'+item.id).then(x => {
                  self.result.data.splice(index, 1);
                  self.status = x.data.code === 0 ? true : false;
                  self.msg = self.status ? x.data.data : x.data.message;
                }).catch(x => {
                  if(console && 'function' === typeof console.log) {
                    console.log(x);
                  }
                  self.msg = '请求失败，请联系管理员解决。';
                  self.status = false;
                });
            }
          },
          del(index) {
            const self = this;
            if(confirm('确定要删除这篇文章吗？')) {
                const item = self.result.data[index];
                axios.post('/api/v1/quotas/del/'+item.id).then(x => {
                  self.status = x.data.code === 0 ? true : false;
                  self.msg = self.status ? x.data.data : x.data.message;
                  self.fetch();
                }).catch(err => {
                  if (console && 'function' === typeof console.log) {
                    console.log(err);
                  }
                  self.msg = '请求失败，请联系管理员解决。';
                  self.status = false;
                });
            }
          },
          fetch(page) {
            page = ('undefined' === typeof page || isNaN(page) )? 1 : page;
            const self = this;
            axios.post('/api/v1/quotas/list', {"size": 20, "page": page}).then(res => {
              self.result = res.data.data;
            }).catch(x => {
              try {
                console.log(x.data);
              } catch (e){

              }
            });
          }
        },
        created() {
            this.fetch();
        }
    }
</script>
