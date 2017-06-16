<template>
    <div class="row">
        <p :class="cls">loading...</p>
    </div>
</template>
<style>
    .cls {
        padding:50px 100px;
        text-align:center;
        margin:auto;
    }
</style>
<script>
    export default {
      name: 'loading',
      props: [
        "className"
      ],
      data() {
        return {
          cls: this.className
        }
      }
    }
</script>
