<template>
    <div class="com-top">
        <a class="uk-button" data-uk-offcanvas="{target:'#sideMenu'}"><i class="show-btn spr hide"></i></a>
        <h1 class="logo"><router-link to="/" title="DevFeed" class="hide">DevFeed</router-link></h1>
        <div class="login">
            <div v-if="loggedIn" class="logined" id="logined">
                <a href="/auth/logout" class="spr">注销</a>
            </div>
            <div v-else class="unlogin" id="unlogin"><a href="/login" class="spr">登录</a></div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "comTop",
        computed: {
          loggedIn() {
            return !window.isGuest;
          }
        }
    }
</script>
