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
                        <router-link tag="li" to="new"><a>最新</a></router-link>
                        <router-link tag="li" to="hot"><a>最热</a></router-link>
                    </ul>
                </div>
                <div class="filter">
                    <dl>
                        <dt><i class="team spr"></i>团队</dt>
                        <dd><a href="/team/16" title="蚂蚁金服体验科技">蚂蚁金服体验科技</a></dd>
                        <dd><a href="/team/7" title="前端观察">前端观察</a></dd>
                        <dd><a href="/team/14" title="凹凸实验室">凹凸实验室</a></dd>
                        <dd><a href="/team/12" title="infoQ">infoQ</a></dd>
                        <dd><a href="/team/11" title="前端外刊评论">前端外刊评论</a></dd>
                        <dd><a href="/team/8" title="奇舞团">奇舞团</a></dd>
                        <dd><a href="/team/13" title="考拉前端团队">考拉前端团队</a></dd>
                        <dd><a href="/team/15" title="知道创宇前端团队">知道创宇前端团队</a></dd>
                        <dd><a href="/team/10" title="京东设计中心">京东设计中心</a></dd>
                        <dd><a href="/team/9" title="前端充电站">前端充电站</a></dd>
                        <dd><a href="/team" title="更多">更多&gt;&gt;</a></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "sideMenu",
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
        }
    }
</script>