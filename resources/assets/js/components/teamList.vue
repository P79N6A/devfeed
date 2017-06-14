<template>
    <div class="row">
        <team-detail v-for="team in teams" :key="team.id" :team="team"></team-detail>
    </div>
</template>
<script>
    import teamDetail from './teamDetail.vue';
    export default {
      name: "teamList",
      props: [
        'teams'
      ],
      components: {
        teamDetail
      }
    }
</script>
