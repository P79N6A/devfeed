<template>
    <div class="container">
        <div class="com-top">
            <a class="uk-button" data-uk-offcanvas="{target:'#sideMenu'}"><i class="show-btn spr hide"></i></a>
            <h1 class="logo"><a href="https://www.devfeed.cn" title="DevFeed" class="hide">DevFeed</a></h1>
            <div class="login">
                <div class="unlogin"><a href="https://www.devfeed.cn/login" class="spr">登录</a></div>
            </div>

        </div>
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
                            @<a :href="article.data.author_url" class="people">{{ article.data.author }}</a><span class="time">{{ article.data.created_at }}</span>
                            <a :href="article.data.source_url" class="origin-link"><i class="spr"></i>查看原文</a>
                        </p>
                    </div>
                    <div class="article"  v-html="article.data.content">
                    </div>
                </div>
            </div>
        </div>
        <div class="com-footer">
            <p>Copyright © 2017 Tgideas</p>
            <p>粤ICP备14011364号-4</p>
        </div>
    </div>
</template>

<script>
    import pagination from './pagination.vue';

    //import paginationx from './paginationx.vue';


    export default {
        name: "adetail",
        data:function(){
            return {
                article:{

                    data:{
                        title:0,
                        author_url:0,
                        author:0

                    }
                },
                aid:0
            }
        },
        created() {
            //alert(1);
            //this.catchage(this.$route);
            //console.log(this.ctype);
            this.$set(this, 'aid', parseInt(this.$route.params.id));
            axios.get('/test_article_'+this.aid+'.js').then(({data}) => {
                //data.content = parser.parseFromString(data.content, "text/xml");

                this.$set(this, 'article', data);
                //console.log (this.article)
                // this.$set(this, 'total', data.total);
                // this.$set(this, 'display', data.per_page);
            });


        }
    }
</script>