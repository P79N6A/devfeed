<template>
    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
        <div class="thumbnail team">
            <img class="logo img-thumbnail" :src="team.logo" alt="team.title" width="200" height="200">
            <div class="caption desc">
                <h3 class="title">{{ team.title }}</h3>
                <p><strong>获赞：{{ team.likes }}</strong>人次</p>
                <p><strong>文章：{{ Math.round(Math.random() * 1000) }}</strong>篇</p>
                <p class="options">
                    <button class="btn btn-primary" role="button" @click="edit(team)">编辑</button>
                    <button class="btn btn-danger" role="button" @click="del(team)">删除</button>
                </p>
            </div>
        </div>
    </div>
</template>
<style>
    .team .logo {
        width: 200px;
        height: 200px;
        max-width:200px;
        max-height:200px;
        min-height:200px;
        min-width:200px;
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
        'team'
      ],
      methods: {
        edit(item) {
          bus.$emit('editteam', item);
        },
        del(item) {
          this.$emit('delteam', item);
        }
      }
    }
</script>
