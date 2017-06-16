<template>
    <div class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ title }}</h4>
                </div>
                <div class="modal-body">
                    <ul class="alert alert-danger" role="alert" v-show="errors.length">
                        <li v-for="message in errors">{{ message }}</li>
                    </ul>
                    <div class="team-form">
                        <div class="form-group">
                            <label for="title">团队名称</label>
                            <input type="text" class="form-control" v-model="attr.title">
                        </div>
                        <div class="form-group">
                            <label for="title">团队网址</label>
                            <input type="url" class="form-control" v-model="attr.website" placeholder="http://">
                        </div>
                        <div class="form-group">
                            <label for="title">团队 LOGO</label>
                            <div class="media">
                                <div class="media-left">
                                    <img :src="attr.logo" v-if="attr.logo" width="200" height="200"
                                         class="media-object img-thumbnail">
                                </div>
                                <div class="media-body">
                                    <p class="help-block">可选择jpg、png格式，尺寸为200x200像素</p>
                                    <input type="file" accept="image/jpeg,image/png" style="margin-bottom:10px" @change="fileChanged">
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title">团队介绍</label>
                            <textarea rows="5" class="form-control" v-model="attr.description" placeholder="输入团队介绍。"></textarea>
                            <p class="help-block">500字以内，支持<strong>Markdown</strong>语法。当前字数：{{ count }} / 500</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="onCancel" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" @click="saveTeam">保存</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</template>
<script>
    export default {
      name: 'teamModal',
      props: ['team'],
      data() {
        return { attr: {
          id: null,
          title:'',
          website: '',
          logo: '/img/team-default.png',
          realLogo: null,
          description: ''
        }, errors: [] };
      },
      watch: {
        team(val) {
          this.attr = val;
        }
      },
      computed: {
        title() {
          return 'undefined' === typeof this.team ? '创建新团队' : '编辑团队';
        },
        count() {
          return this.attr.description.length || 0;
        }
      },
      methods: {
        onCancel() {
          bus.$emit('modalCanceled');
        },
        fileChanged(evt) {
          let file = evt.target.files[0];
          this.$set(this.attr, 'realLogo', file);
          let reader = new FileReader();
          reader.onload = e => {
            this.$set(this.attr, 'logo', e.target.result);
          }
          reader.readAsDataURL(file);
        },
        saveTeam() {
          let form = new FormData();
          for ( var key in this.attr ) {
            if(this.attr[key])
                form.append(key, this.attr[key]);
          }
          form.delete('logo');
          form.delete('realLogo');
          let file = this.attr.realLogo;
          if(file && 'object' === typeof file && (file.type === "image/png" || file.type === "image/jpeg")) {
            form.append('logo', file);
          }
          axios.post('/api/v1/teams/save', form)
            .then(x => {
              let result = x.data;
              console.log(result);
              switch (result.ret) {
                case 1: // 验证失败
                  this.errors = result.message;
                  break;
                case 404: // 模型不存在
                  this.errors = ['要编辑的团队不存在，可能已被删除。'];
                  break;
                case 2: // 保存失败
                  this.errors = ['保存团队信息失败，请联系开发人员排查。'];
                  break;
                default:
                  bus.$emit('teamSaved', result.message);
              }
            }).catch(e => {
              this.errors = [ e.message ];
          })
        }
      }
    }
</script>
