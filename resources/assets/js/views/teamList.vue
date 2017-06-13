<template>
    <div class="team-wrap">
        <div class="row" v-if="loading">
            <p>loading...</p>
        </div>
        <div class="row" v-if="teams.data">
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2" v-for="(team,index) in teams.data">
                <div class="thumbnail team">
                    <img class="logo" :src="team.logo" alt="team.title" width="200" height="200">
                    <div class="caption desc">
                        <h3 class="title">{{ team.title }}</h3>
                        <p><strong>获赞：{{ team.likes }}</strong>人次</p>
                        <p><strong>文章：{{ Math.round(Math.random() * 1000) }}</strong>篇</p>
                        <p class="options">
                            <button class="btn btn-primary" role="button">编辑</button>
                            <button class="btn btn-danger" role="button">删除</button>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-12" v-show="teams.last_page > 1">
                <ul class="pagination">
                    <li v-if="teams.prev_page_url"><a href="#" @click.prevent="prevPage"
                                                       rel="prev">上一页</a></li>
                    <li v-else class="disabled"><span>上一页</span></li>
                    <li class="disabled"><span>{{ teams.current_page
                        }} / {{ parseInt(teams.total / teams.per_page) + 1 }}</span></li>
                    <li v-if="teams.next_page_url"><a href="#" @click.prevent="nextPage"
                                                       rel="next">下一页</a></li>
                    <li v-else class="disabled"><span>下一页</span></li>
                </ul>
            </div>
        </div>
    </div>

</template>
<style>
.team-wrap {
    padding:0 15px;
    min-width:500px;
}
.team .logo {
    width:200px;
    height:auto;
}
.team .title {
    width:100%;
    word-wrap:normal;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-overflow-ellipsis: '...';
}
.team .intro {
    height:90px;
    margin-bottom:10px;
    overflow:hidden;
}
</style>
<script>
    export default {
      name: "teamList",
      data() {
        return {
          loading: true,
          page: 1,
          pageSize: 10,
          teams: []
        }
      },
      watch: {
        page() {
          this.loadTeams();
        },
        pageSize() {
          this.loadTeams();
        }
      },
      methods: {
        loadTeams() {
          axios.get('http://fedn.local/api/v1/teams/list', {params: {page:this.page, size: this.pageSize}}).then(res => {
            this.loading = false;
            this.teams = res.data;
          })
        },
        prevPage() {
          this.page -= 1;
        },
        nextPage() {
          this.page += 1;
        },
        edit(index) {

        },
        del(id) {

        }
      },
      created() {
        this.loadTeams();
      }
    }
</script>
