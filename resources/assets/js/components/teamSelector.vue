<template>
    <select v-model="selected" @change="teamChange">
        <option v-for="{id, title, disabled} in teams" :key="id" :value="id" :disabled="disabled">{{ title }}</option>
    </select>
</template>
<script>
    export default {
      name: "teamSelector",
      props: {
        site: {
          team_id: null,
        }
      },
      data() {
        return {
          selected: null,
          teams: [{id:null, title:'请选择所属团队',disabled:true},{id:null, title:'======================',disabled:true}],
        }
      },
      watch: {
        site(val) {
          this.selected = val.team_id;
        }
      },
      methods: {
        teamChange() {
          bus.$emit('teamChange', this.selected);
        }
      },
      created() {
        axios.get('/api/v1/teams/list').then(({data}) => {
          this.$set(this, 'teams', this.teams.concat(data.data));
        })
      }
    }
</script>
