<template>
<div class="com-main">
    <div class="main-tt">
        <h2>团队</h2>
    </div>
    <div class="main-con">
        <ul class="list clearfix"><!--通过类名list、item进行列表展示方式的切换-->
            <li class="team-intro">
                <a :href="teamer.website" class="list-pic team-logo" target="_blank" rel="noopener external nofollow"><img :src="teamer.logo" :alt="teamer.title" /></a>
                <h3><a :href="teamer.website" target="_blank" rel="noopener external nofollow">{{ teamer.title }}</a></h3>
                <p class="list-intro">{{ teamer.title }}</p>
            </li>
            <li v-for="article in articles.data">
                <router-link :to="'/article/'+article.id" class="list-pic">
                    <img :src="article.figure" :alt="article.title">
                </router-link>
                <h3><router-link class="title" :to="'/article/'+article.id">{{ article.title }}</router-link>
                    <span class="read-all spr">{{ article.click_count }}</span>
                </h3>
                <p class="list-intro">{{ article.summary }}</p>
                <p class="list-infor">
                    <a v-if="article.team" :href="article.team.website" class="team" target="_blank" rel="noopener external nofollow">{{ article.team.title }}</a>@
                    <a :href="article.author_url" class="people" target="_blank" rel="noopener external nofollow">{{ article.author }}</a>
                    <span class="time">{{ article.publish_time }} </span>
                    <a :href="article.source_url" target="_blank" class="origin-link" rel="noopener external nofollow"><i class="spr"></i></a>
                </p>

            </li>
        </ul>
        <pagination :total="total" :current-page='current'  ref="pagination" @pagechange="pagechange"></pagination>
    </div>
</div>
</template>

<script>
    import pagination from './pagination.vue';

    export default {
        name: "tdetail",
        data:function(){
            return {
                teamer:{title:''},
                articles:{},
                total: 0,     // 记录总条数
                display: 10,   // 每页显示条数
                tid:1,
                current:1,
                currentPage:1,
            }
        },
        watch: {
            $route:function(){
                let routes = this.$route;
                if(routes.params.pid) this.current = parseInt(routes.params.pid); else this.current = 1;
                var dataUrl = "/api/v2/team/detail?id="+this.tid+"&page="+this.current;
                axios.get(dataUrl).then(({data}) => {
                    if(data.code == 46001) {
                        this.$router.push({path: '/error404'});
                    }
                    else if(!(this.current>data.data.last_page) && this.current > 0) {
                        this.$set(this, 'teamer', {
                            'logo': data.data.logo,
                            'title': data.data.title,
                            'website': data.data.website
                        });
                        this.$set(this, 'articles', data.data.articles);
                        this.$set(this, 'total', data.data.articles.total);
                        this.$set(this, 'display', data.data.articles.per_page);
                        this.$refs.pagination.setCurrent(this.current);
                    }else{
                        this.$router.push({path: '/error404'});
                    }
                });
            }
        },
        methods: {
            pagechange:function(currentPage){
                this.current= currentPage;
                this.$router.push({ path:"/team/"+this.tid+"/"+this.current+"/", params: { tid:  this.tid,pid:this.current}});
            }
        },
        components: {
            'pagination': pagination,
        },
        created() {
            let routes = this.$route;
            if(routes.params.pid) this.current = parseInt(routes.params.pid);
            if(routes.params.tid) this.tid = parseInt(routes.params.tid);
        console.log(this.current );


            let dataUrl;
            dataUrl = "/api/v2/team/detail?id="+this.tid+"&page="+this.current;
            axios.get(dataUrl).then(({data}) => {
                if(data.code == 46001) {
                    this.$router.push({path: '/error404'});
                }
                else if(!(this.current>data.data.articles.last_page) && this.current > 0) {
                    this.$set(this, 'teamer', {
                        'logo': data.data.logo,
                        'title': data.data.title,
                        'website': data.data.website
                    });
                    this.$set(this, 'articles', data.data.articles);
                    this.$set(this, 'total', data.data.articles.total);
                    this.$set(this, 'display', data.data.articles.per_page);
                }else{
                    this.$router.push({path: '/error404'});
                }
            });
        }
    }
</script>
