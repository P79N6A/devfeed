<template>
<div class="com-main">
    <div class="main-tt">
        <h2>团队</h2>
    </div>
    <div class="main-con">
        <ul class="list clearfix"><!--通过类名list、item进行列表展示方式的切换-->
            <li class="team-intro">
                <a :href="teamer.website" class="list-pic team-logo"><img  :src="teamer.logo" :alt="teamer.title" /></a>
                <h3><a :href="teamer.website">{{ teamer.title }}</a></h3>
                <p class="list-intro"><p>{{ teamer.title }}</p></p>
            </li>
            <li v-for="article in articles.data">
                <a href="/article/161" class="list-pic">
                    <img :src="article.figure" :alt="article.title">
                </a>
                <h3><a class="title" :href="'/article/'+article.id">{{ article.title }}</a>
                    <span class="read-all spr">{{ article.click_count }}</span>
                </h3>
                <p class="list-intro">{{ article.summary }}</p>
                <p class="list-infor">
                    <a v-if="article.team" :href="article.team.website" class="team">{{ article.team.title }}</a>@
                    <a :href="article.author_url" class="people">{{ article.author }}</a>
                    <span class="time">{{ article.publish_time }} </span>
                    <a :href="article.source_url" target="_blank" class="origin-link"><i class="spr"></i></a>
                </p>

            </li>
        </ul>
        <pagination :total="total" :current-page='current'  ref="pagination" @pagechange="pagechange"></pagination>
    </div>
</div>
</template>

<script>
    import pagination from './pagination.vue';

    //import paginationx from './paginationx.vue';
    export default {
        name: "tdetail",
        data:function(){
            return {
                teamer:{title:''},
                articles:{},
                total: 0,     // 记录总条数
                display: 10,   // 每页显示条数
                current:1,
                currentPage:1,
            }
        },
        computed: {
            // id() {
            //     // 我们很快就会看到 `params` 是什么
            //     return this.$route.params.id
            // }
        },
        watch: {
            currentPage: 'requestData',
            $route:function(){
                // this.catchage(this.$route);
                // this.$set(this, 'currentPage', 1);

            }
        },
        ready () {
            console.log();
            this.requestData()
        },
        methods: {
            catchage:function(routes){
                let dataUrl;
                dataUrl = "/api/v2/team/detail?id="+this.current;
                axios.get(dataUrl).then(({data}) => {
                    this.$set(this, 'articles', data.data.articles);
                    this.$set(this, 'total', data.data.articles.total);
                    this.$set(this, 'display', data.data.articles.per_page);
                });
                if(this.$refs.pagination) this.$refs.pagination.setCurrent(1);
            },
            pagechange:function(currentPage){
                let dataUrl;
                dataUrl = "/api/v2/team/detail?id="+this.current;
                axios.get(dataUrl).then(({data}) => {
                    this.$set(this, 'articles', data.data.articles);
                    // this.$router.push({ path: '/'+this.ctype+'/'+currentPage, params: { id: currentPage }})

                });
            },
            requestData:function () {
                // 在这里使用ajax或者fetch将对应页传过去获取数据即可
            }
        },
        components: {
            'pagination': pagination,
        },
        created() {
            // this.catchage(this.$route);
            if(!isNaN(this.$route.params.id)) this.$set(this, 'current', parseInt(this.$route.params.id));

            let dataUrl;
            dataUrl = "/api/v2/team/detail?id="+this.current;
            console.log(dataUrl);
            axios.get(dataUrl).then(({data}) => {
                console.log(data);
                this.$set(this, 'teamer',{'logo':data.data.logo,'title':data.data.title,'website':data.data.website});
                this.$set(this, 'articles', data.data.articles);
                this.$set(this, 'total', data.data.articles.total);
                this.$set(this, 'display', data.data.articles.per_page);
                //console.log(this.articles);
            });
        }
    }
</script>