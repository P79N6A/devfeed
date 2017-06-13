<template>
    <table class="table table-bordered">
        <thead class="bg-primary">
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>logo</th>
            <th>简介</th>
            <th>赞</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(row, index) in teams">
            <td>{{ row.id }}</td>
            <td><a :href="row.website" :title="row.title">{{ row.title }}</a></td>
            <td><img :src="row.logo" width="80" height="80"></td>
            <td v-html="row.description_html"></td>
            <td>{{ row.likes }}</td>
            <td>
                <button @click="edit(index)" class="btn btn-xs btn-success">编辑</button>
                <button @click="del(row.id)" class="btn btn-xs btn-danger">删除</button>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
      name: "teamList",
      data() {
        return {
          teams: []
        }
      },
      methods: {
        loadTeams() {
          axios.get('http://fedn.local/api/v1/teams/list').then(res => {
            this.teams = res.data;
          })
        },
        edit(index) {

        },
        del(id) {

        }
      },
      mounted() {
        this.loadTeams()
      }
    }
</script>
