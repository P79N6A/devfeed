<template>
    <div>
        <sideMenu></sideMenu>
        <div class="container">
            <comTop></comTop>
            <router-view></router-view>
            <comFoot></comFoot>
        </div>
    </div>
</template>
<script>
    import sideMenu from './sideMenu.vue';
    import comTop from './comTop.vue';
    import comFoot from './comFoot.vue';
    export default {
        name: "home",
        computed: {
            username () {
                // 我们很快就会看到 `params` 是什么
                return this.$route.params.username
            }
        },
        components: {
            sideMenu,
            'comFoot': comFoot,
            'comTop': comTop,
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