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
                    axios.get('/api/v2/articles/list?page='+this.current+'&size=10').then(({data}) => {
                        if(!(this.current>data.last_page) && this.current > 0) {
                            this.$set(this, 'articles', data);
                            this.$set(this, 'total', data.total);
                            this.$set(this, 'display', data.per_page);
                        }else{
                            this.$router.push({path:'/error404'});
                        }
                    });
                    if(this.$refs.pagination) this.$refs.pagination.setCurrent(1);

                }else if(/\/hot/.test(routes.path)&&this.ctype!="hot"){
                    this.ctype= "hot";
                    axios.get('/api/v2/articles/list?page='+this.current+'&size=10&hot=1').then(({data}) => {
                        if(!(this.current>data.last_page) && this.current > 0) {
                            this.$set(this, 'articles', data);
                            this.$set(this, 'total', data.total);
                            this.$set(this, 'display', data.per_page);
                        }else{
                            this.$router.push({path:'/error404'});
                        }
                    });
                    if(this.$refs.pagination) this.$refs.pagination.setCurrent(1);
                }
            },
            pagechange:function(currentPage){
                let dataUrl;
                if(this.ctype == "hot"){
                    dataUrl = '/api/v2/articles/list?page='+this.current+'&size=10&hot=1';
                }else{
                    dataUrl = '/api/v2/articles/list?page='+this.current+'&size=10';
                }
                axios.get(dataUrl).then(({data}) => {
                    if(!(this.current>data.last_page) && this.current > 0) {
                        this.$set(this, 'articles', data);
                        this.$router.push({ path: '/'+this.ctype+'/'+currentPage, params: { id: currentPage }})
                    }else{
                        this.$router.push({path:'/error404'});
                    }
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
            this.catchage(this.$route);
            if(!isNaN(this.$route.params.id)) this.$set(this, 'current', parseInt(this.$route.params.id));
            else this.$set(this, 'current', 1);

            let dataUrl;
            if(this.ctype == "hot"){
                dataUrl = '/api/v2/articles/list?page='+this.current+'&size=10&hot=1';
            }else{
                dataUrl = '/api/v2/articles/list?page='+this.current+'&size=10';
            }
            axios.get(dataUrl).then(({data}) => {
                console.log(data);
                if(!(this.current>data.last_page) && this.current > 0) {
                    this.$set(this, 'articles', data);
                    this.$set(this, 'total', data.total);
                    this.$set(this, 'display', data.per_page);
                }else{
                    //this.$router.push({path:'/error404'})
                }


            });
        }
    }
</script>