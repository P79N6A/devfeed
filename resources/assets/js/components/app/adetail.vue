<template>
<div class="com-main">
    <div class="main-con">
        <div class="article-top">
            <div class="break-nav">
                <a href="https://www.devfeed.cn/" title="最新">最新</a><em>&gt;</em><span>{{ article.data.title }}</span>
            </div>

        </div>

        <div class="article-con">
            <div class="article-tt">
                <h3>{{ article.data.title }}</h3>
                <p class="article-infor">
                    <a v-if="article.team" :href="article.team.website" class="team">{{ article.team.title }}</a>
                    @<a :href="article.data.author_url" class="people">{{ article.data.author }}</a><span class="time">{{ article.data.publish_time }}</span>
                    <a :href="article.data.source_url" class="origin-link"><i class="spr"></i>查看原文</a>
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
                this.$set(this, 'article', data);
            });


        }
    }
</script>