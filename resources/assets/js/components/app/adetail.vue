<template>
<div class="com-main">
    <div class="main-con">
        <div class="article-top">
            <div class="break-nav">
                <router-link to="/new" title="最新">最新</router-link><em>&gt;</em><span>{{ article.data.title }}</span>
            </div>

        </div>

        <div class="article-con">
            <div class="article-tt">
                <h3>{{ article.data.title }}</h3>
                <p class="article-infor">
                    <a v-if="article.team" :href="article.team.website" class="team" target="_blank" rel="noopener external nofollow">{{ article.team.title }}</a>
                    @<a :href="article.data.author_url" class="people" target="_blank" rel="noopener external nofollow">{{ article.data.author }}</a><span class="time">{{ article.data.publish_time }}</span>
                    <a :href="article.data.source_url" class="origin-link" target="_blank" rel="noopener external nofollow"><i class="spr"></i>查看原文</a>
                </p>
            </div>
            <div class="article"  v-html="article.data.content">
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import pagination from './pagination.vue';
    export default {
        name: "adetail",
        data:function(){
            return {
                article:{

                    data:{
                        title:'',
                        author_url:'',
                        author:''

                    }
                },
                aid:''
            }
        },
        created() {
            this.$set(this, 'aid', parseInt(this.$route.params.id));
            axios.get('/api/v2/article/detail?id='+this.aid).then(({data}) => {
                if(data.code == 46001) {
                    this.$router.push({path: '/error404'});
                }else this.$set(this, 'article', data);
            });


        }
    }
</script>
