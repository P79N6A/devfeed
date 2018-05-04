<template>
    <div class="com-top">
        <a class="uk-button" data-uk-offcanvas="{target:'#sideMenu'}"><i class="show-btn spr hide"></i></a>
        <h1 class="logo"><a href="/" title="DevFeed" class="hide">DevFeed</a></h1>
        <div class="login">
            <div v-if="loginStatus" class="unlogin" id="unlogin"><a href="/login" class="spr">登录</a></div>
            <div v-if="!loginStatus" class="logined" id="logined" style="display:none"><a href="/auth/logout" class="spr">注销</a></div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "comTop",
        data:function(){
            return {
                loginStatus:!!window.status
            }
        },
        computed: {},
        methods: {}
    }
</script>