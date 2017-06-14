<template>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <ul class="pagination">
            <li v-if="pages.prev_page_url"><a href="#" @click.prevent="change(-1)"
                                              rel="prev">上一页</a></li>
            <li v-else class="disabled"><span>上一页</span></li>
            <li class="disabled"><span>{{ pages.current_page }} / {{ totalPage }}</span></li>
            <li v-if="pages.next_page_url"><a href="#" @click.prevent="change(1)"
                                              rel="next">下一页</a></li>
            <li v-else class="disabled"><span>下一页</span></li>
        </ul>
    </div>
</template>
<script>
    export default {
      name: 'pager',
      data() {
        return { pages: {
          prev_page_url: null,
          current_page: 1,
          total: 1,
          current_page: 1,
          next_page_url: null,
          from: 0,
          to: 0
        }}
      },
      computed: {
        totalPage() {
          return Math.ceil(this.pages.total / this.pages.per_page);
        }
      },
      methods: {
        change(diff) {
          bus.$emit('pageChange', diff);
        },
        changed(items) {
          this.pages = items;
        }
      },
      created() {
        bus.$on('pageChanged', this.changed);
      },
      destroyed() {
        bus.$off('pageChanged', this.changed);
      }
    }
</script>
