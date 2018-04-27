<template>
    <div>
        <h1>example</h1>
        <p>example </p>

    </div>

</template>
<script>
    export default {
        name: "Example",
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