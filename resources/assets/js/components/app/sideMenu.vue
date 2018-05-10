<template>
    <div class="side-menu">
        <div class="">
            <a href="javascript:void(0);" class="toggle-btn">
                <i class="hide-btn">收起</i>
                <i class="show-btn spr hide"></i>
            </a>
            <div class="side-menu-con">
                <div class="main-tag">
                    <ul>
                        <router-link tag="li" to="/new"><a>最新</a></router-link>
                        <router-link tag="li" to="/hot"><a>最热</a></router-link>
                    </ul>
                </div>
                <div class="filter">
                    <dl>
                        <dt><i class="team spr"></i>团队</dt>
                        <dd v-for="item in teamData"><a :href="'/team/'+item.id" :title="item.title">{{ item.title }}</a></dd>
                        <dd><a href="/teams" title="更多">更多&gt;&gt;</a></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "sideMenu",
        data:function(){
            return {
                teamData:{},
            }
        },
        computed: {
            username () {
                // 我们很快就会看到 `params` 是什么
                return this.$route.params.username
            }
        },
        methods: {
            goBack () {
                window.history.length > 1
                    ? this.$router.go(-1)
                    : this.$router.push('/')
            }
        },
        created() {
            let dataUrl = "/api/v2/teams/list?page=1&size=10"
            axios.get(dataUrl).then(({data}) => {
                this.$set(this, 'teamData', data.data);
            });

        }
    }
</script>