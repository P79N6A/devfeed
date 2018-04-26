<template>
    <div class="container">
        <div class="com-top">
            <a class="uk-button" data-uk-offcanvas="{target:'#sideMenu'}"><i class="show-btn spr hide"></i></a>
            <h1 class="logo"><a href="/" title="DevFeed" class="hide">DevFeed</a></h1>
            <div class="login">
                <div class="unlogin"><a href="/login" class="spr">登录</a></div>
            </div>

        </div>
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
                        <a href="/article/161" class="list-pic">
                            <img :src="article.figure" :alt="article.title">
                        </a>
                        <h3><a class="title" :href="'/article/161'+article.id">{{ article.title }}</a>
                            <span class="read-all spr">{{ article.click_count }}</span>
                        </h3>
                        <p class="list-intro">{{ article.summary }}</p>
                        <p class="list-infor">
                            <a :href="article.author_url" class="team">{{ article.author }}</a>@
                            <a href="javascript:void(0)" class="people">未知数据</a>
                            <span class="time">{{ article.updated_at }}</span>
                            <a :href="article.source_url" target="_blank" class="origin-link"><i class="spr"></i></a>
                        </p>

                    </li>
                </ul>
                <span v-for="n in articles.last_page">{{ n }} </span>
                <pagination :total="total" :current-page='current'  ref="pagination" @pagechange="pagechange"></pagination>
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
        name: "alist",
        data:function(){
            return {
                articles:{},
                total: 323,     // 记录总条数
                display: 10,   // 每页显示条数
                current:1,
                currentPage:1,
                ctype:"hot"
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
                this.catchage(this.$route);
                this.$set(this, 'currentPage', 1);

            }
        },
        ready () {
            this.requestData()
        },
        methods: {
            catchage:function(routes){
                if(/\/new/.test(routes.path)&&this.ctype!="new"){
                    this.ctype= "new";
                    axios.get('/test_'+this.ctype+'_'+this.current+'.js').then(({data}) => {
                        this.$set(this, 'articles', data);
                        this.$set(this, 'total', data.total);
                        this.$set(this, 'display', data.per_page);
                    });
                    if(this.$refs.pagination) this.$refs.pagination.setCurrent(1);

                }else if(/\/hot/.test(routes.path)&&this.ctype!="hot"){
                    this.ctype= "hot";
                    axios.get('/test_'+this.ctype+'_'+this.current+'.js').then(({data}) => {
                        this.$set(this, 'articles', data);
                        this.$set(this, 'total', data.total);
                        this.$set(this, 'display', data.per_page);
                    });
                    if(this.$refs.pagination) this.$refs.pagination.setCurrent(1);
                }
            },
            pagechange:function(currentPage){
                axios.get('/test_'+this.ctype+'_'+currentPage+'.js').then(({data}) => {
                    this.$set(this, 'articles', data);
                    this.$router.push({ path: '/'+this.ctype+'/'+currentPage, params: { id: currentPage }})

                });
            },
            requestData:function () {
                alert(1);
                // 在这里使用ajax或者fetch将对应页传过去获取数据即可
            }
        },
        components: {
            'pagination': pagination,
        },
        created() {
            this.catchage(this.$route);
            console.log(this.ctype);
            if(!isNaN(this.$route.params.id)) this.$set(this, 'current', parseInt(this.$route.params.id));
            else this.$set(this, 'current', 1);

            axios.get('/test_'+this.ctype+'_'+this.current+'.js').then(({data}) => {
                console.log(data);
                this.$set(this, 'articles', data);
                this.$set(this, 'total', data.total);
                this.$set(this, 'display', data.per_page);
            });
        }
    }
</script>