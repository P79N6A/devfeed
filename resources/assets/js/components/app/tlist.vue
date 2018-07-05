<template>
<div class="com-main">
    <div class="main-tt">
        <h2>团队</h2>
    </div>
    <div class="main-con">
        <ul class="list clearfix teamlist"><!--通过类名list、item进行列表展示方式的切换-->
            <li  v-for="article in articles">
                <router-link :to="'/team/'+article.id" class="list-pic team-logo"><img :src="article.logo" :alt="article.title" /></router-link>
                <h3><router-link :to="'/team/'+article.id">{{ article.title }} </router-link><span class="article-num">{{ article.articles_count }}</span></h3>
                <p class="list-intro">{{ article.description }}</p>
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
                total: 1,     // 记录总条数
                display: 10,   // 每页显示条数
                current:1,
                currentPage:1,
            }
        },
        watch: {
            $route:function(){
                let routes = this.$route;
                if(routes.params.id) this.current = parseInt(routes.params.id); else this.current = 1;
                let dataUrl = "/api/v2/teams/list?page="+this.current+"&size=10";
                axios.get(dataUrl).then(({data}) => {
                    if(!(this.current>data.last_page) && this.current > 0) {
                        this.$set(this, 'articles', data.data);
                        this.$set(this, 'total', data.total);
                        this.$set(this, 'display', data.per_page);
                        this.$refs.pagination.setCurrent(this.current);
                    }
                    else{
                        this.$router.push({path:'/error404'});
                    }
                });
            }
        },
        methods: {
            pagechange:function(currentPage){
                this.current= currentPage;
                this.$router.push({ path:"/teams/"+this.current+"&size=10", params: { id:  this.current }});
            }
        },
        components: {
            'pagination': pagination,
        },
        created() {
            let routes = this.$route;
            if(routes.params.id) this.current = parseInt(routes.params.id);
            let dataUrl;
            dataUrl = "/api/v2/teams/list?page="+this.current+"&size=10";
            axios.get(dataUrl).then(({data}) => {
                if(!(this.current>data.last_page) && this.current > 0) {
                    this.$set(this, 'articles', data.data);
                    this.$set(this, 'total', data.total);
                    this.$set(this, 'display', data.per_page);
                }
                else{
                        this.$router.push({path:'/error404'});
                    }
            });
        }
    }
</script>
