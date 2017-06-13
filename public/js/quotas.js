webpackJsonp([1],{

/***/ 12:
/***/ (function(module, exports) {

// this module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  scopeId,
  cssModules
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  // inject cssModules
  if (cssModules) {
    var computed = Object.create(options.computed || null)
    Object.keys(cssModules).forEach(function (key) {
      var module = cssModules[key]
      computed[key] = function () { return module }
    })
    options.computed = computed
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ 14:
/***/ (function(module, exports, __webpack_require__) {

/**
 * Created by kaireewu on 2016/11/18.
 */
/* eslint no-new: 1 */

__webpack_require__(5);

window.Vue = __webpack_require__(3);

var quotaList = __webpack_require__(36);
var siteList = __webpack_require__(37);

'use strict';

var app = new Vue({
  el: '#quotaApp',
  components: {
    quotaList: quotaList,
    siteList: siteList
  }
});

/***/ }),

/***/ 33:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'quotaList',
  data: function data() {
    return { result: {}, msg: '', status: true };
  },

  methods: {
    closeAlert: function closeAlert() {
      this.msg = false;
      this.status = true;
    },
    publish: function publish(index) {
      var self = this;
      if (confirm('确定要发布这篇文章吗？')) {
        var item = self.result.data[index];
        self.$set(self.result.data[index], 'onqueue', true);
        self.result.data[index] = item;
        axios.post('/api/v1/quotas/publish/' + item.id).then(function (x) {
          self.result.data.splice(index, 1);
          self.status = x.data.code === 0 ? true : false;
          self.msg = self.status ? x.data.data : x.data.message;
        }).catch(function (x) {
          if (console && 'function' === typeof console.log) {
            console.log(x);
          }
          self.msg = '请求失败，请联系管理员解决。';
          self.status = false;
        });
      }
    },
    del: function del(index) {
      var self = this;
      if (confirm('确定要删除这篇文章吗？')) {
        var item = self.result.data[index];
        axios.post('/api/v1/quotas/del/' + item.id).then(function (x) {
          self.status = x.data.code === 0 ? true : false;
          self.msg = self.status ? x.data.data : x.data.message;
          self.fetch();
        }).catch(function (err) {
          if (console && 'function' === typeof console.log) {
            console.log(err);
          }
          self.msg = '请求失败，请联系管理员解决。';
          self.status = false;
        });
      }
    },
    fetch: function fetch(page) {
      page = 'undefined' === typeof page || isNaN(page) ? 1 : page;
      var self = this;
      axios.post('/api/v1/quotas/list', { "size": 20, "page": page }).then(function (res) {
        self.result = res.data.data;
      }).catch(function (x) {
        try {
          console.log(x.data);
        } catch (e) {}
      });
    }
  },
  created: function created() {
    this.fetch();
  }
});

/***/ }),

/***/ 34:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'siteList',
  data: function data() {
    return {
      rows: [],
      form: {
        "name": "",
        "url": "",
        "list_url": "",
        "sel_link": "",
        "sel_title": "",
        "sel_content": "",
        "sel_tag": "",
        "sel_author_link": "",
        "sel_author_name": "",
        "published": false
      }
    };
  },

  methods: {
    edit: function edit(index) {
      this.form = Object.assign({}, this.rows[index]);
    },
    del: function del(id) {
      var self = this;
      axios.post('/api/v1/site/del/' + id).then(function () {
        self.loadSites.call(self);
      }).catch(function (e) {
        try {
          console.log(e);
        } catch (e) {}
      });
    },
    submit: function submit() {
      var _this = this;

      axios.post('/api/v1/site', this.form).then(function () {
        _this.loadSites();
      }).catch(function () {
        console.log('fail');
      });
    },
    checkFetch: function checkFetch() {
      axios.post('/api/v1/site/check', this.form).then(function (x) {
        try {
          console.log(x.data.data);
        } catch (e) {}
      }).catch(function (e) {
        try {

          console.log('fail');
        } catch (e) {}
      });
    },
    fetch: function fetch(id) {
      try {
        console.log('wait...');
      } catch (e) {}
      var self = this;

      axios.post('/api/v1/site/fetch/' + id).then(function (x) {
        self.loadSites();
      }).catch(function (e) {
        try {
          console.log(e);
        } catch (e) {}
      });
    },
    loadSites: function loadSites() {
      var _this2 = this;

      axios.post('/api/v1/sites', { size: 20 }).then(function (response) {
        var result = response.data;
        _this2.rows = result.data.data;
      }).catch(function (error) {
        try {
          console.log(error);
        } catch (e) {}
      });
    }
  },
  mounted: function mounted() {
    this.loadSites();
  }
});

/***/ }),

/***/ 36:
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(12)(
  /* script */
  __webpack_require__(33),
  /* template */
  __webpack_require__(38),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "E:\\codes\\fedn\\resources\\assets\\js\\views\\quotaList.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] quotaList.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-570df139", Component.options)
  } else {
    hotAPI.reload("data-v-570df139", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),

/***/ 37:
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(12)(
  /* script */
  __webpack_require__(34),
  /* template */
  __webpack_require__(39),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "E:\\codes\\fedn\\resources\\assets\\js\\views\\siteList.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] siteList.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-d50bd65c", Component.options)
  } else {
    hotAPI.reload("data-v-d50bd65c", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),

/***/ 38:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.msg),
      expression: "msg"
    }],
    staticClass: "alert alert-dismissible",
    class: {
      'alert-success': _vm.status, 'alert-danger': !_vm.status
    },
    attrs: {
      "role": "alert"
    }
  }, [_c('button', {
    staticClass: "close",
    attrs: {
      "type": "button"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.closeAlert()
      }
    }
  }, [_c('span', {
    attrs: {
      "aria-hidden": "true"
    }
  }, [_vm._v("×")]), _vm._v(" "), _c('span', {
    staticClass: "sr-only"
  }, [_vm._v("Close")])]), _vm._v(" "), _c('strong', [_vm._v(_vm._s(_vm.msg))])]), _vm._v(" "), _c('table', {
    staticClass: "table table-bordered"
  }, [_vm._m(0), _vm._v(" "), _c('tbody', _vm._l((_vm.result.data), function(row, index) {
    return _c('tr', [_c('td', [_vm._v(_vm._s(row.id))]), _vm._v(" "), _c('td', [_c('a', {
      attrs: {
        "href": row.url,
        "title": row.title
      }
    }, [_vm._v(_vm._s(row.title))])]), _vm._v(" "), _c('td', [_c('a', {
      attrs: {
        "href": row.site_url,
        "title": row.site_name
      }
    }, [_vm._v(_vm._s(row.site_name))])]), _vm._v(" "), _c('td', [_c('a', {
      attrs: {
        "href": row.author_url,
        "title": row.author_name
      }
    }, [_vm._v(_vm._s(row.author_name))])]), _vm._v(" "), _c('td', [_vm._v(_vm._s(row.tags))]), _vm._v(" "), _c('td', [_c('button', {
      staticClass: "btn btn-xs btn-warning",
      attrs: {
        "disabled": row.onqueue
      },
      on: {
        "click": function($event) {
          _vm.publish(index)
        }
      }
    }, [_vm._v("发布")]), _vm._v(" "), _c('button', {
      staticClass: "btn btn-xs btn-danger",
      on: {
        "click": function($event) {
          _vm.del(index)
        }
      }
    }, [_vm._v("删除")])])])
  }))]), _vm._v(" "), _c('ul', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.result.total > 1),
      expression: "result.total > 1"
    }],
    staticClass: "pagination"
  }, [(_vm.result.prev_page_url) ? _c('li', [_c('a', {
    attrs: {
      "href": "#",
      "rel": "prev"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.fetch(_vm.result.current_page - 1)
      }
    }
  }, [_vm._v("上一页")])]) : _c('li', {
    staticClass: "disabled"
  }, [_c('span', [_vm._v("上一页")])]), _vm._v(" "), _c('li', {
    staticClass: "disabled"
  }, [_c('span', [_vm._v(_vm._s(_vm.result.current_page) + " / " + _vm._s(parseInt(_vm.result.total / _vm.result.per_page) + 1))])]), _vm._v(" "), (_vm.result.next_page_url) ? _c('li', [_c('a', {
    attrs: {
      "href": "#",
      "rel": "next"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.fetch(_vm.result.current_page + 1)
      }
    }
  }, [_vm._v("下一页")])]) : _c('li', {
    staticClass: "disabled"
  }, [_c('span', [_vm._v("下一页")])])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('thead', {
    staticClass: "bg-primary"
  }, [_c('tr', [_c('th', [_vm._v("ID")]), _vm._v(" "), _c('th', [_vm._v("标题")]), _vm._v(" "), _c('th', [_vm._v("站点")]), _vm._v(" "), _c('th', [_vm._v("作者")]), _vm._v(" "), _c('th', [_vm._v("标签")]), _vm._v(" "), _c('th', [_vm._v("操作")])])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-570df139", module.exports)
  }
}

/***/ }),

/***/ 39:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "row"
  }, [_c('div', {
    staticClass: "col-sm-9"
  }, [_c('table', {
    staticClass: "table table-bordered"
  }, [_vm._m(0), _vm._v(" "), _c('tbody', _vm._l((_vm.rows), function(row, index) {
    return _c('tr', [_c('td', [_vm._v(_vm._s(row.id))]), _vm._v(" "), _c('td', [_c('a', {
      attrs: {
        "href": row.url,
        "title": row.name
      }
    }, [_vm._v(_vm._s(row.name))])]), _vm._v(" "), _c('td', [_vm._v(_vm._s(row.published ? '是' : '否'))]), _vm._v(" "), _c('td', [_vm._v(_vm._s(row.last_check))]), _vm._v(" "), _c('td', [_vm._v(_vm._s(row.list_url))]), _vm._v(" "), _c('td', [_c('button', {
      staticClass: "btn btn-xs btn-success",
      on: {
        "click": function($event) {
          _vm.edit(index)
        }
      }
    }, [_vm._v("编辑")]), _vm._v(" "), _c('button', {
      staticClass: "btn btn-xs btn-danger",
      on: {
        "click": function($event) {
          _vm.del(row.id)
        }
      }
    }, [_vm._v("删除")]), _vm._v(" "), _c('button', {
      staticClass: "btn btn-xs btn-primary",
      on: {
        "click": function($event) {
          _vm.fetch(row.id)
        }
      }
    }, [_vm._v("抓取")])])])
  }))])]), _vm._v(" "), _c('div', {
    staticClass: "col-sm-3"
  }, [_c('div', {
    staticClass: "form"
  }, [_c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "form-label",
    attrs: {
      "for": "name"
    }
  }, [_vm._v("名称")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.name),
      expression: "form.name"
    }],
    staticClass: "form-control",
    attrs: {
      "name": "name",
      "id": "name",
      "type": "text"
    },
    domProps: {
      "value": (_vm.form.name)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.form.name = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "form-label",
    attrs: {
      "for": "url"
    }
  }, [_vm._v("地址")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.url),
      expression: "form.url"
    }],
    staticClass: "form-control",
    attrs: {
      "name": "url",
      "id": "url",
      "type": "text"
    },
    domProps: {
      "value": (_vm.form.url)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.form.url = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "form-label",
    attrs: {
      "for": "list_url"
    }
  }, [_vm._v("列表页地址")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.list_url),
      expression: "form.list_url"
    }],
    staticClass: "form-control",
    attrs: {
      "name": "list_url",
      "id": "list_url",
      "type": "text"
    },
    domProps: {
      "value": (_vm.form.list_url)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.form.list_url = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "form-label",
    attrs: {
      "for": "selLink"
    }
  }, [_vm._v("链接选择器")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.sel_link),
      expression: "form.sel_link"
    }],
    staticClass: "form-control",
    attrs: {
      "name": "selLink",
      "id": "selLink",
      "type": "text",
      "placeholder": "选择器对应元素href属性为详情页url"
    },
    domProps: {
      "value": (_vm.form.sel_link)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.form.sel_link = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "form-label",
    attrs: {
      "for": "selTitle"
    }
  }, [_vm._v("标题选择器")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.sel_title),
      expression: "form.sel_title"
    }],
    staticClass: "form-control",
    attrs: {
      "name": "selTitle",
      "id": "selTitle",
      "type": "text",
      "placeholder": "选择器对应元素innerText为标题"
    },
    domProps: {
      "value": (_vm.form.sel_title)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.form.sel_title = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "form-label",
    attrs: {
      "for": "selContent"
    }
  }, [_vm._v("内容选择器")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.sel_content),
      expression: "form.sel_content"
    }],
    staticClass: "form-control",
    attrs: {
      "name": "selContent",
      "id": "selContent",
      "type": "text",
      "placeholder": "选择器对应元素的innerHTML为内容"
    },
    domProps: {
      "value": (_vm.form.sel_content)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.form.sel_content = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "form-label",
    attrs: {
      "for": "selTag"
    }
  }, [_vm._v("标签选择器")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.sel_tag),
      expression: "form.sel_tag"
    }],
    staticClass: "form-control",
    attrs: {
      "name": "selTag",
      "id": "selTag",
      "type": "text",
      "placeholder": "选择器对应元素的innerText为标签"
    },
    domProps: {
      "value": (_vm.form.sel_tag)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.form.sel_tag = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "form-label",
    attrs: {
      "for": "selAuthorLink"
    }
  }, [_vm._v("作者地址选择器")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.sel_author_link),
      expression: "form.sel_author_link"
    }],
    staticClass: "form-control",
    attrs: {
      "name": "selAuthor",
      "id": "selAuthorLink",
      "type": "text",
      "placeholder": "选择器对应元素的href为作者地址"
    },
    domProps: {
      "value": (_vm.form.sel_author_link)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.form.sel_author_link = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "form-label",
    attrs: {
      "for": "selAuthorName"
    }
  }, [_vm._v("作者名称选择器")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.sel_author_name),
      expression: "form.sel_author_name"
    }],
    staticClass: "form-control",
    attrs: {
      "name": "selAuthor",
      "id": "selAuthorName",
      "type": "text",
      "placeholder": "选择器对应元素的innerText为作者地址"
    },
    domProps: {
      "value": (_vm.form.sel_author_name)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.form.sel_author_name = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "form-label",
    attrs: {
      "for": "published"
    }
  }, [_vm._v("自动发布 "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.published),
      expression: "form.published"
    }],
    attrs: {
      "type": "checkbox",
      "name": "published",
      "value": "true",
      "id": "published"
    },
    domProps: {
      "checked": Array.isArray(_vm.form.published) ? _vm._i(_vm.form.published, "true") > -1 : (_vm.form.published)
    },
    on: {
      "__c": function($event) {
        var $$a = _vm.form.published,
          $$el = $event.target,
          $$c = $$el.checked ? (true) : (false);
        if (Array.isArray($$a)) {
          var $$v = "true",
            $$i = _vm._i($$a, $$v);
          if ($$c) {
            $$i < 0 && (_vm.form.published = $$a.concat($$v))
          } else {
            $$i > -1 && (_vm.form.published = $$a.slice(0, $$i).concat($$a.slice($$i + 1)))
          }
        } else {
          _vm.form.published = $$c
        }
      }
    }
  })])])]), _vm._v(" "), _c('button', {
    staticClass: "btn btn-success",
    on: {
      "click": _vm.checkFetch
    }
  }, [_vm._v("测试抓取")]), _vm._v(" "), _c('button', {
    staticClass: "btn btn-primary",
    on: {
      "click": _vm.submit
    }
  }, [_vm._v("保存站点")])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('thead', {
    staticClass: "bg-primary"
  }, [_c('tr', [_c('th', [_vm._v("ID")]), _vm._v(" "), _c('th', [_vm._v("名称")]), _vm._v(" "), _c('th', [_vm._v("自动发布")]), _vm._v(" "), _c('th', [_vm._v("最后采集时间")]), _vm._v(" "), _c('th', [_vm._v("列表地址")]), _vm._v(" "), _c('th', [_vm._v("操作")])])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-d50bd65c", module.exports)
  }
}

/***/ }),

/***/ 41:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(14);


/***/ }),

/***/ 5:
/***/ (function(module, exports, __webpack_require__) {

window._ = __webpack_require__(2);

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = __webpack_require__(1);

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

var token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });

/***/ })

},[41]);