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

    const emptyTeam = {title: '', logo: '', website: '', description: ''};

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
          currentTeam: emptyTeam,
          index: -1
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
        reset() {
          this.currentTeam = emptyTeam;
          this.index = -1;
        },
        loadTeams() {
          axios.get('/api/v1/teams/list', {
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
        addTeam() {
          this.currentTeam = emptyTeam;
          this.index = -1;
          jQuery('#teamModal').modal('show');
        },
        editteam(team, index) {
          this.index = index;
          this.currentTeam = team;
          jQuery('#teamModal').modal('show');
        },
        delteam(team, index) {
          //console.log(team)
          axios.post('/api/v1/teams/del', {id:team.id}).then( x => {
            const { ret, message } = x.data;
            if(ret == 0) {
              this.teams.data.splice(index, 1);
            } else {
              alert(message);
            }
          }).catch(e=>{
            console.log(e);
          });
        },
        teamSaved(team) {
          if(this.index !== -1) {
            this.teams.data.splice(this.index, 1,team);
          } else {
            this.teams.data.unshift(team);
          }
          jQuery('#teamModal').modal('hide');
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
        bus.$on('addTeam', this.addTeam);
        bus.$on('teamSaved', this.teamSaved);
        bus.$on('modalCanceled', this.reset);
      },
      destroyed() {
        bus.$off('editteam', this.editteam);
        bus.$off('delteam', this.delteam);
        bus.$off('pageChange', this.pageChange);
        bus.$off('addTeam', this.addTeam);
        bus.$off('teamSaved', this.teamSaved);
      }
    };

</script>
