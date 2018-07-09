<template>
<div class="com-main">
    <div class="main-tt">
        <h2 v-if="ctype === 'hot'">
            最热
        </h2>
        <h2 v-else-if="ctype === 'new'">
            最新
        </h2>
        <div class="type-btns" style="display: block;">
            <a href="javascript:void(0);" title="list" class="list spr hide on">list</a>
            <a href="javascript:void(0);" title="imte" class="item spr hide ">item</a>
        </div>
    </div>
    <div class="main-con">
        <ul class="list clearfix list"><!--通过类名list、item进行列表展示方式的切换-->
            <li v-for="article in articles.data">
                <router-link :to="'/article/'+article.id" class="list-pic">
                    <img :src="article.figure" :alt="article.title">
                </router-link>
                <h3><router-link class="title" :to="'/article/'+article.id">{{ article.title }}</router-link>
                    <span class="read-all spr">{{ article.click_count }}</span>
                </h3>
                <p class="list-intro">{{ article.summary }}</p>
                <p class="list-infor">
                    <a v-if="article.team" :to="article.team.website" class="team" target="_blank" rel="noopener external nofollow">{{ article.team.title }}</a>@
                    <a :href="article.author_url" class="people" target="_blank" rel="noopener external nofollow">{{ article.author }}</a>
                    <span class="time">{{ article.publish_time }} </span>
                    <a :href="article.source_url" target="_blank" rel="noopener external nofollow" class="origin-link"><i class="spr"></i></a>
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
        name: "alist",
        data:function(){
            return {
                articles:{},
                total: 0,     // 记录总条数
                display: 10,   // 每页显示条数
                current:1,
                currentPage:1,
                ctype:"hot"
            }
        },
        watch: {
            $route:function(){
                let routes = this.$route;
                if(routes.params.id) this.current = parseInt(routes.params.id); else this.current = 1;
                if(/\/new/.test(routes.path)&&this.ctype!="new"){ this.ctype= "new";}
                else if(/\/hot/.test(routes.path)&&this.ctype!="hot"){this.ctype= "hot";}


                let dataUrl;
                if(this.ctype == "hot"){
                    dataUrl = '/api/v2/articles/list?page='+this.current+'&size=10&hot=1';
                }else{
                    dataUrl = '/api/v2/articles/list?page='+this.current+'&size=10';
                }
                axios.get(dataUrl).then(({data}) => {
                    if(!(this.current>data.last_page) && this.current > 0) {
                        this.$set(this, 'articles', data);
                        this.$refs.pagination.setCurrent(this.current);
                    }else{
                        this.$router.push({path:'/error404'});
                    }
                });
            }
        },
        methods: {
            pagechange:function(currentPage){
                this.current = currentPage;
                this.$router.push({
                  path: '/'+this.ctype+'/'+ this.current,
                  params: { id:  this.current }
                });
            }
        },
        components: {
            'pagination': pagination,
        },
        created() {
            let routes = this.$route;
            if(routes.params.id) this.current = parseInt(routes.params.id);
            if(/\/new/.test(routes.path)&&this.ctype!="new"){
                this.ctype= "new";
            }else if(/\/hot/.test(routes.path)&&this.ctype!="hot"){
                this.ctype= "hot";
            }

            let dataUrl;
            if(this.ctype == "hot"){
                dataUrl = '/api/v2/articles/list?page='+this.current+'&size=10&hot=1';
            }else{
                dataUrl = '/api/v2/articles/list?page='+this.current+'&size=10';
            }
            axios.get(dataUrl).then(({data}) => {
                if(!(this.current>data.last_page) && this.current > 0) {
                    this.$set(this, 'articles', data);
                    this.$set(this, 'total', data.total);
                    this.$set(this, 'display', data.per_page);
                }else{
                    this.$router.push({path:'/error404'})
                }
            });
        }
    }
</script>
