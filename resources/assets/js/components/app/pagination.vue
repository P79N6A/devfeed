<template>
    <div class="pages" v-if="total!=0">
        <ul class="pagination">
            <li :class="{'disabled': current == 1}"><a href="javascript:;" @click="setCurrent(1)"> 首页 </a></li>
            <li :class="{'disabled': current == 1}"><a href="javascript:;" @click="setCurrent(current - 1)">«</a></li>
            <li v-for="p in grouplist" :class="{'active': current == p.val}"><a href="javascript:;" @click="setCurrent(p.val)"> {{ p.text }} </a></li>
            <li :class="{'disabled': current == page}"><a href="javascript:;" @click="setCurrent(current + 1)">»</a></li>
            <li :class="{'disabled': current == page}"><a href="javascript:;" @click="setCurrent(page)"> 末页 </a></li>

        </ul>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                current: this.currentPage
            }
        },
        props: {
            total: {// 数据总条数
                type: Number,
                default: 0
            },
            display: {// 每页显示条数
                type: Number,
                default: 10
            },
            currentPage: {// 当前页码
                type: Number,
                default: 1
            },
            pagegroup: {// 分页条数
                type: Number,
                default: 5,
                coerce: function (v) {
                    v = v > 0 ? v : 5;
                    return v % 2 === 2 ? v : v + 1;
                }
            }
        },
        computed: {
            page: function () { // 总页数
                return Math.ceil(this.total / this.display);
            },
            grouplist: function () { // 获取分页页码
                let len = this.page, temp = [], list = [], count = Math.floor(this.pagegroup / 2), center = this.current;
                if (len <= this.pagegroup) {
                    while (len--) {
                        temp.push({text: this.page - len, val: this.page - len});
                    }
                    ;
                    return temp;
                }else if(len>this.pagegroup){
                    if(this.current < this.pagegroup){
                        for(let i=1; i<= this.pagegroup; i++){
                            temp.push({text: i, val: i});
                        }
                        if (this.current <= len-2) {//最后一页追加“...”代表省略的页
                            temp.push({text: '...', val:null});
                        }
                    }else if(this.current >= this.pagegroup){
                        for(let i=1; i<= 2; i++){
                            temp.push({text: i, val: i});
                        }
                        temp.push({text: '...', val: null});
                        if (this.current+1 == len) {//当前页+1等于总页码
                            for(let i = this.current-1; i <= len; i++){//“...”后面跟三个页码当前页居中显示
                                temp.push({text: i, val: i});
                            }
                        }else if (this.current == len) {//当前页数等于总页数则是最后一页页码显示在最后

                            for(let i = this.current-2; i <= len; i++){//...后面跟三个页码当前页居中显示
                                temp.push({text: i, val: i});
                            }

                        }else{//当前页小于总页数，则最后一页后面跟...
                            for(let i = this.current-1; i <= this.current+1; i++){//dqPage+1页后面...
                                temp.push({text: i, val: i});
                            }
                            temp.push({text: '...', val: null});
                        }
                    }
                }
                list = temp;
                return list;
            }
        },
        methods: {
            setCurrent: function (idx) {

                if (this.current != idx && idx > 0 && idx < this.page + 1) {
                    this.current = idx;
                    this.$emit('pagechange', this.current);
                }
            }
        }

    }
</script>