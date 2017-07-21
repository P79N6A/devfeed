<template>
    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
        <div class="thumbnail team">
            <img class="logo img-thumbnail" :src="team.logo" alt="team.title" width="200" height="200">
            <div class="caption desc">
                <h4 class="title">{{ team.title }}</h4>
                <p><strong>获赞：{{ team.likes }}</strong>人次</p>
                <p><strong>文章：{{ team.articles_count }}</strong>篇</p>
                <p class="options">
                    <button class="btn btn-primary" role="button" @click="edit(team)">编辑</button>
                    <button class="btn btn-danger" role="button" @click="delTeam(team)">删除</button>
                </p>
            </div>
        </div>
    </div>
</template>
<style>
    .team .logo {
        width: 100%;
        height: auto;
    }

    .team .title {
        font-size: 20px;
        font-weight:bold;
        width: 100%;
        word-wrap: normal;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-overflow-ellipsis: '...';
    }
    .team .intro {
        height: 90px;
        margin-bottom: 10px;
        overflow: hidden;
    }
</style>
<script>
    export default {
      name: 'teamDetail',
      props:[
        'index',
        'team'
      ],
      methods: {
        edit(item) {
          bus.$emit('editteam', item, this.index);
        },
        delTeam(item) {
          bus.$emit('delteam', item, this.index);
        }
      }
    }
</script>
