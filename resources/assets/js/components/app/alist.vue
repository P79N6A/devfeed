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
                <h2>最热</h2>
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
                        <h3><a class="title" href="/article/161">{{ article.title }}</a>
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
                <div class="pages">
                    <ul class="pagination">

                        <li class="disabled"><span>«</span></li>





                        <li class="active"><span>1</span></li>
                        <li><a href="/hot?page=2">2</a></li>
                        <li><a href="/hot?page=3">3</a></li>
                        <li><a href="/hot?page=4">4</a></li>
                        <li><a href="/hot?page=5">5</a></li>
                        <li><a href="/hot?page=6">6</a></li>
                        <li><a href="/hot?page=7">7</a></li>
                        <li><a href="/hot?page=8">8</a></li>
                        <li class="disabled"><span>...</span></li>
                        <li><a href="/hot?page=31">31</a></li>
                        <li><a href="/hot?page=32">32</a></li>
                        <li><a href="/hot?page=2" rel="next">»</a></li>


                    </ul>

                </div>


                <!--<template>-->
                    <!--<v-pagination :total="total" :current-page='current' @pagechange="pagechange"></v-pagination>-->
                <!--</template>-->

                <v-pagination :total="total" :current-page='current' @pagechange="pagechange"></v-pagination>


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
                num: 30,
                limit: 3,
                current:1,
            }
        },
        computed: {
            username () {
                // 我们很快就会看到 `params` 是什么
                return this.$route.params.username
            }
        },
        watch: {
            currentPage: 'requestData'
        },
        ready () {
            this.requestData()
        },
        methods: {
            pagechange:function(currentPage){
                console.log(currentPage);
                // ajax请求, 向后台发送 currentPage, 来获取对应的数据

            },
            requestData:function () {
                // 在这里使用ajax或者fetch将对应页传过去获取数据即可
            }
        },
        components: {
            'v-pagination': pagination,
        },
        created() {
            //console.log(this.$route.path);
            axios.get('/test_hot_1.js').then(({data}) => {
                //console.log(data);
                //console.log( this.formatTime(123123123123) );
                this.$set(this, 'articles', data);
                //this.$set(this, 'current_page', this.articles.concat(data.data));
            })
        }
    }
</script>