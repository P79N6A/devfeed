<template>
    <div class="team-wrap">
        <loading :className="loading" v-if="loading"></loading>
        <team-list v-if="teams.data" :teams="teams.data"></team-list>
        <pager @pagechange="pageChange" v-if="teams.data"></pager>
        <team-modal slot="modal" id="teamModal" :team="currentTeam"></team-modal>
    </div>
</template>
<style>
    .team-wrap {
        padding: 0 15px;
        min-width: 500px;
    }
</style>
<script>
    import loading from '../components/loading.vue';
    import teamList from '../components/teamList.vue';
    import pager from '../components/pager.vue';
    import teamModal from '../components/teamModal.vue';

    export default {
      name: 'viewHome',
      data() {
        return {
          loading: true,
          page:1,
          pageSize:10,
          teams: {
            data:[]
          },
          currentTeam: null
        }
      },
      watch: {
        page() {
          this.loadTeams();
        },
        pageSize() {
          this.loadTeams();
        }
      },
      methods: {
        loadTeams() {
          axios.get('http://fedn.local/api/v1/teams/list', {
            params: {
              page: this.page,
              size: this.pageSize
            }
          }).then(res => {
            if(this.loading)
              this.loading = false;

            this.teams = res.data;
            bus.$emit('pageChanged', res.data);
          })
        },
        pageChange(diff) {
          this.page += diff;
        },
        editteam(team) {
          this.currentTeam = team;
          jQuery('#teamModal').modal('show');
        },
        delteam(team) {
          console.log(team)
        }
      },
      components: {
        loading,
        teamList,
        pager,
        teamModal
      },
      created() {
        this.loadTeams();
        bus.$on('editteam', this.editteam);
        bus.$on('delteam', this.delteam);
        bus.$on('pageChange', this.pageChange);
      },
      destroyed() {
        bus.$off('editteam', this.editteam);
        bus.$off('delteam', this.delteam);
        bus.$off('pageChange', this.pageChange);
      }
    };

</script>
