<template>
    <div>
        <Loading v-show="showLoading"></Loading>
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
    import Loading from './loading.vue';
    import { mapGetters } from 'vuex';
    export default {
        name: "home",
        computed:mapGetters([
            'showLoading'
        ]),
        components: {
            sideMenu,
            'comFoot': comFoot,
            'comTop': comTop,
            'Loading':Loading
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