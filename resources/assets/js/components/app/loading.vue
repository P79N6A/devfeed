<style>
    #loading{position:fixed; background-color:#fff; left:0; width:100%; height:100%; top:0;}
</style>
<template>
    <div id="loading">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
        加载中，请稍后...
    </div>
</template>
<script>
    export default {
        name: "loading"
    }
</script>