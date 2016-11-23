<template>
    <div class="row">
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead class="bg-primary">
                <tr>
                    <th>ID</th>
                    <th>名称</th>
                    <th>自动发布</th>
                    <th>最后采集时间</th>
                    <th>列表地址</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(row,index) in rows">
                    <td>{{ row.id }}</td>
                    <td><a :href="row.url" :title="row.name">{{ row.name }}</a></td>
                    <td>{{ row.published ? '是' : '否' }}</td>
                    <td>{{ row.last_check }}</td>
                    <td>{{ row.list_url }}</td>
                    <td>
                        <button @click="edit(index)" class="btn btn-xs btn-success">编辑</button>
                        <button class="btn btn-xs btn-danger">删除</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-3">
            <div class="form">
                <div class="form-group">
                    <label for="name" class="form-label">名称</label>
                    <input name="name" id="name" class="form-control" type="text" v-model="form.name">
                </div>
                <div class="form-group">
                    <label for="url" class="form-label">地址</label>
                    <input name="url" id="url" class="form-control" type="text" v-model="form.url">
                </div>
                <div class="form-group">
                    <label for="list_url" class="form-label">列表页地址</label>
                    <input name="list_url" id="list_url" class="form-control" type="text" v-model="form.list_url">
                </div>
                <div class="form-group">
                    <label for="selLink" class="form-label">链接选择器</label>
                    <input name="selLink" id="selLink" class="form-control" type="text" v-model="form.sel_link" placeholder="选择器对应元素href属性为详情页url">
                </div>
                <div class="form-group">
                    <label for="selTitle" class="form-label">标题选择器</label>
                    <input name="selTitle" id="selTitle" class="form-control" type="text" v-model="form.sel_title" placeholder="选择器对应元素innerText为标题">
                </div>
                <div class="form-group">
                    <label for="selContent" class="form-label">内容选择器</label>
                    <input name="selContent" id="selContent" class="form-control" type="text" v-model="form.sel_content" placeholder="选择器对应元素的innerHTML为内容">
                </div>
                <div class="form-group">
                    <label for="selTag" class="form-label">标签选择器</label>
                    <input name="selTag" id="selTag" class="form-control" type="text" v-model="form.sel_tag" placeholder="选择器对应元素的innerText为标签">
                </div>
                <div class="form-group">
                    <label for="selAuthorLink" class="form-label">作者地址选择器</label>
                    <input name="selAuthor" id="selAuthorLink" class="form-control" type="text" v-model="form.sel_author_link" placeholder="选择器对应元素的href为作者地址">
                </div>
                <div class="form-group">
                    <label for="selAuthorName" class="form-label">作者名称选择器</label>
                    <input name="selAuthor" id="selAuthorName" class="form-control" type="text" v-model="form.sel_author_name" placeholder="选择器对应元素的innerText为作者地址">
                </div>
                <div class="form-group">
                    <label for="published" class="form-label">自动发布 <input type="checkbox" name="published" v-model="form.published" value="true" id="published"></label>
                </div>
            </div>
            <button @click="submit" class="btn btn-primary">添加站点</button>
        </div>
    </div>
</template>
<script>

    export default {
        name: 'siteList',
        data() {
            return {
              rows: [],
              form: {
                "name": "",
                "url": "",
                "list_url": "",
                "sel_link": "",
                "sel_title": "",
                "sel_content": "",
                "sel_tag": "",
                "sel_author_link": "",
                "sel_author_name": "",
                "published": false
              }
            }
        },
        methods: {
          edit(index) {
            this.form = this.rows[index]
            console.log(this)
          },
          submit() {
              this.$http.post('/api/v1/site', this.form).then((x)=>{
                  console.log('ok')
              }, (e) => {
                  console.log('fail')
              })
          }
        },
        mounted() {
            this.$http.post('/api/v1/sites',{size:20}).then((response) => {
              const result = response.data;
              this.rows = result.data.data
            }, (error) => {
              console.log(error)
            })
        }
    }

</script>
