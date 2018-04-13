webpackJsonp([4],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/source/list.vue":
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

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'SourceList',
  data: function data() {
    return { hasResult: false, result: { data: [] }, msg: '', status: true };
  },

  watch: {
    hasResult: function hasResult() {
      return self.result.data > 0;
    }
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

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/views/source.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'SourceView'
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/component-normalizer.js":
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
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
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-077fdcc8\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/views/source.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "col-md-8 col-md-offset-2" },
    [_c("router-view")],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-077fdcc8", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-5e9fa2b8\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/source/list.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { attrs: { id: "sourceList" } }, [
    _c(
      "div",
      {
        directives: [
          { name: "show", rawName: "v-show", value: _vm.msg, expression: "msg" }
        ],
        staticClass: "alert alert-dismissible",
        class: { "alert-success": _vm.status, "alert-danger": !_vm.status },
        attrs: { role: "alert" }
      },
      [
        _c(
          "button",
          {
            staticClass: "close",
            attrs: { type: "button" },
            on: {
              click: function($event) {
                $event.preventDefault()
                _vm.closeAlert()
              }
            }
          },
          [
            _c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")]),
            _vm._v(" "),
            _c("span", { staticClass: "sr-only" }, [_vm._v("Close")])
          ]
        ),
        _vm._v(" "),
        _c("strong", [_vm._v(_vm._s(_vm.msg))])
      ]
    ),
    _vm._v(" "),
    !_vm.hasResult
      ? _c(
          "div",
          { staticClass: "alert alert-info", attrs: { role: "alert" } },
          [_c("p", [_vm._v("暂无数据")])]
        )
      : _vm._e(),
    _vm._v(" "),
    _vm.hasResult
      ? _c("table", { staticClass: "table table-bordered" }, [
          _vm._m(0),
          _vm._v(" "),
          _c(
            "tbody",
            _vm._l(_vm.result.data, function(row, index) {
              return _c("tr", [
                _c("td", [_vm._v(_vm._s(row.id))]),
                _vm._v(" "),
                _c("td", [
                  _c("a", { attrs: { href: row.url, title: row.title } }, [
                    _vm._v(_vm._s(row.title))
                  ])
                ]),
                _vm._v(" "),
                _c("td", [
                  _c(
                    "a",
                    { attrs: { href: row.site_url, title: row.site_name } },
                    [_vm._v(_vm._s(row.site_name))]
                  )
                ]),
                _vm._v(" "),
                _c("td", [
                  _vm._v(_vm._s(row.team ? row.team.title : "未设定"))
                ]),
                _vm._v(" "),
                _c("td", [
                  _c(
                    "a",
                    { attrs: { href: row.author_url, title: row.author_name } },
                    [_vm._v(_vm._s(row.author_name))]
                  )
                ]),
                _vm._v(" "),
                _c("td", [_vm._v(_vm._s(row.tags))]),
                _vm._v(" "),
                _c("td", [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-xs btn-warning",
                      attrs: { disabled: row.onqueue },
                      on: {
                        click: function($event) {
                          _vm.publish(index)
                        }
                      }
                    },
                    [_vm._v("发布\n                ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-xs btn-danger",
                      on: {
                        click: function($event) {
                          _vm.del(index)
                        }
                      }
                    },
                    [_vm._v("删除")]
                  )
                ])
              ])
            })
          )
        ])
      : _vm._e(),
    _vm._v(" "),
    _c(
      "ul",
      {
        directives: [
          {
            name: "show",
            rawName: "v-show",
            value: _vm.result.total > 1,
            expression: "result.total > 1"
          }
        ],
        staticClass: "pagination"
      },
      [
        _vm.result.prev_page_url
          ? _c("li", [
              _c(
                "a",
                {
                  attrs: { href: "#", rel: "prev" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      _vm.fetch(_vm.result.current_page - 1)
                    }
                  }
                },
                [_vm._v("上一页")]
              )
            ])
          : _c("li", { staticClass: "disabled" }, [
              _c("span", [_vm._v("上一页")])
            ]),
        _vm._v(" "),
        _c("li", { staticClass: "disabled" }, [
          _c("span", [
            _vm._v(
              _vm._s(_vm.result.current_page) +
                " / " +
                _vm._s(parseInt(_vm.result.total / _vm.result.per_page) + 1)
            )
          ])
        ]),
        _vm._v(" "),
        _vm.result.next_page_url
          ? _c("li", [
              _c(
                "a",
                {
                  attrs: { href: "#", rel: "next" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      _vm.fetch(_vm.result.current_page + 1)
                    }
                  }
                },
                [_vm._v("下一页")]
              )
            ])
          : _c("li", { staticClass: "disabled" }, [
              _c("span", [_vm._v("下一页")])
            ])
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "bg-primary" }, [
      _c("tr", [
        _c("th", [_vm._v("ID")]),
        _vm._v(" "),
        _c("th", [_vm._v("标题")]),
        _vm._v(" "),
        _c("th", [_vm._v("站点")]),
        _vm._v(" "),
        _c("th", [_vm._v("团队")]),
        _vm._v(" "),
        _c("th", [_vm._v("作者")]),
        _vm._v(" "),
        _c("th", [_vm._v("标签")]),
        _vm._v(" "),
        _c("th", [_vm._v("操作")])
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-5e9fa2b8", module.exports)
  }
}

/***/ }),

/***/ "./resources/assets/js/bootstrap.js":
/***/ (function(module, exports, __webpack_require__) {

//window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

//window.axios = require('axios');


/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */
if ('undefined' === typeof window.axios) {
  window.axios = __webpack_require__("./node_modules/axios/index.js");
}
var token = document.head.querySelector('meta[name="csrf-token"]');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
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

/***/ }),

/***/ "./resources/assets/js/components/source/list.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/source/list.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-5e9fa2b8\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/source/list.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources\\assets\\js\\components\\source\\list.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5e9fa2b8", Component.options)
  } else {
    hotAPI.reload("data-v-5e9fa2b8", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/assets/js/routes/source.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue__ = __webpack_require__("./node_modules/vue/dist/vue.common.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_router__ = __webpack_require__("./node_modules/vue-router/dist/vue-router.esm.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_source_list_vue__ = __webpack_require__("./resources/assets/js/components/source/list.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_source_list_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__components_source_list_vue__);




__WEBPACK_IMPORTED_MODULE_0_vue___default.a.use(__WEBPACK_IMPORTED_MODULE_1_vue_router__["default"]);

/* harmony default export */ __webpack_exports__["a"] = (new __WEBPACK_IMPORTED_MODULE_1_vue_router__["default"]({
  mode: 'history',
  base: '/admin/source/',
  routes: [{
    path: '/',
    name: 'SourceList',
    component: __WEBPACK_IMPORTED_MODULE_2__components_source_list_vue___default.a
  }]
}));

/***/ }),

/***/ "./resources/assets/js/source.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue__ = __webpack_require__("./node_modules/vue/dist/vue.common.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__routes_source__ = __webpack_require__("./resources/assets/js/routes/source.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__views_source__ = __webpack_require__("./resources/assets/js/views/source.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__views_source___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__views_source__);


__webpack_require__("./resources/assets/js/bootstrap.js");







__WEBPACK_IMPORTED_MODULE_0_vue___default.a.config.productionTip = false;

new __WEBPACK_IMPORTED_MODULE_0_vue___default.a({
  el: '#sourceApp',
  router: __WEBPACK_IMPORTED_MODULE_1__routes_source__["a" /* default */],
  template: '<source-view />',
  components: { SourceView: __WEBPACK_IMPORTED_MODULE_2__views_source___default.a }
});

/***/ }),

/***/ "./resources/assets/js/views/source.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/views/source.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-077fdcc8\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/views/source.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources\\assets\\js\\views\\source.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-077fdcc8", Component.options)
  } else {
    hotAPI.reload("data-v-077fdcc8", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 2:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/source.js");


/***/ })

},[2]);