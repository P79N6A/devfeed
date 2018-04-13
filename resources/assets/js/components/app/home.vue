<template>
    <div>
        <sideMenu></sideMenu>
        <router-view></router-view>
    </div>
</template>
<script>
    import sideMenu from './sideMenu.vue';
    export default {
        name: "home",
        computed: {
            username () {
                // 我们很快就会看到 `params` 是什么
                return this.$route.params.username
            }
        },
        components: {
            sideMenu
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