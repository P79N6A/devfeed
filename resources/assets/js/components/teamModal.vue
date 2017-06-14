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
                    <div class="team-form">
                        <div class="form-group">
                            <label for="title">团队名称</label>
                            <input type="text" class="form-control" :value="attr.title">
                        </div>
                        <div class="form-group">
                            <label for="title">团队网址</label>
                            <input type="url" class="form-control" :value="attr.website" placeholder="http://">
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
                                    <input type="file" style="margin-bottom:10px">
                                    <button class="btn btn-sm btn-primary">上传</button>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title">团队介绍</label>
                            <textarea rows="5" class="form-control" v-html="attr.description" placeholder="输入团队介绍。"></textarea>
                            <p class="help-block">1000字以内，支持<strong>Markdown</strong>语法</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary">保存</button>
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
          title:null,
          website: null,
          logo: null,
          description: null
        } };
      },
      watch: {
        team(val) {
          this.attr = val;
        }
      },
      computed: {
        title() {
          return 'undefined' === typeof this.team ? '创建新团队' : '编辑团队';
        }
      }
    }
</script>
