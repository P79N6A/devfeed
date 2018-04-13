webpackJsonp([1],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/loading.vue":
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

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'loading',
  props: ["className"],
  data: function data() {
    return {
      cls: this.className
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/pager.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

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
  name: 'pager',
  data: function data() {
    var _pages;

    return { pages: (_pages = {
        prev_page_url: null,
        current_page: 1,
        total: 1
      }, _defineProperty(_pages, 'current_page', 1), _defineProperty(_pages, 'next_page_url', null), _defineProperty(_pages, 'from', 0), _defineProperty(_pages, 'to', 0), _pages) };
  },

  computed: {
    totalPage: function totalPage() {
      return Math.ceil(this.pages.total / this.pages.per_page);
    }
  },
  methods: {
    change: function change(diff) {
      bus.$emit('pageChange', diff);
    },
    changed: function changed(items) {
      this.pages = items;
    }
  },
  created: function created() {
    bus.$on('pageChanged', this.changed);
  },
  destroyed: function destroyed() {
    bus.$off('pageChanged', this.changed);
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/teamDetail.vue":
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

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'teamDetail',
  props: ['index', 'team'],
  methods: {
    edit: function edit(item) {
      bus.$emit('editteam', item, this.index);
    },
    delTeam: function delTeam(item) {
      bus.$emit('delteam', item, this.index);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/teamList.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__teamDetail_vue__ = __webpack_require__("./resources/assets/js/components/teamDetail.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__teamDetail_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__teamDetail_vue__);
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
  name: "teamList",
  props: ['teams'],
  components: {
    teamDetail: __WEBPACK_IMPORTED_MODULE_0__teamDetail_vue___default.a
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/teamModal.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

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
  name: 'teamModal',
  props: ['team'],
  data: function data() {
    return { attr: {
        id: null,
        title: '',
        website: '',
        logo: '/img/team-default.png',
        realLogo: null,
        description: ''
      }, errors: [] };
  },

  watch: {
    team: function team(val) {
      this.attr = val;
    }
  },
  computed: {
    title: function title() {
      return 'undefined' === typeof this.team ? '创建新团队' : '编辑团队';
    },
    count: function count() {
      return this.attr.description.length || 0;
    }
  },
  methods: {
    onCancel: function onCancel() {
      bus.$emit('modalCanceled');
    },
    fileChanged: function fileChanged(evt) {
      var _this = this;

      var file = evt.target.files[0];
      this.$set(this.attr, 'realLogo', file);
      var reader = new FileReader();
      reader.onload = function (e) {
        _this.$set(_this.attr, 'logo', e.target.result);
      };
      reader.readAsDataURL(file);
    },
    saveTeam: function saveTeam() {
      var _this2 = this;

      var form = new FormData();
      for (var key in this.attr) {
        if (this.attr[key]) form.append(key, this.attr[key]);
      }
      form.delete('logo');
      form.delete('realLogo');
      var file = this.attr.realLogo;
      if (file && 'object' === (typeof file === 'undefined' ? 'undefined' : _typeof(file)) && (file.type === "image/png" || file.type === "image/jpeg")) {
        form.append('logo', file);
      }
      axios.post('/api/v1/teams/save', form).then(function (x) {
        var result = x.data;
        console.log(result);
        switch (result.ret) {
          case 1:
            // 验证失败
            _this2.errors = result.message;
            break;
          case 404:
            // 模型不存在
            _this2.errors = ['要编辑的团队不存在，可能已被删除。'];
            break;
          case 2:
            // 保存失败
            _this2.errors = ['保存团队信息失败，请联系开发人员排查。'];
            break;
          default:
            _this2.errors = [];
            bus.$emit('teamSaved', result.message);
        }
      }).catch(function (e) {
        _this2.errors = [e.message];
      });
    }
  },
  created: function created() {
    var _this3 = this;

    var modal = this;
    jQuery('#teamModal').on('hidden.bs.modal', function () {
      _this3.errors = [];
    });
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/views/team.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_loading_vue__ = __webpack_require__("./resources/assets/js/components/loading.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_loading_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__components_loading_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_teamList_vue__ = __webpack_require__("./resources/assets/js/components/teamList.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_teamList_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__components_teamList_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_pager_vue__ = __webpack_require__("./resources/assets/js/components/pager.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_pager_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__components_pager_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_teamModal_vue__ = __webpack_require__("./resources/assets/js/components/teamModal.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_teamModal_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__components_teamModal_vue__);
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






var emptyTeam = { title: '', logo: '', website: '', description: '' };

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'viewHome',
  data: function data() {
    return {
      loading: true,
      page: 1,
      pageSize: 10,
      teams: {
        data: []
      },
      currentTeam: emptyTeam,
      index: -1
    };
  },

  watch: {
    page: function page() {
      this.loadTeams();
    },
    pageSize: function pageSize() {
      this.loadTeams();
    }
  },
  methods: {
    reset: function reset() {
      this.currentTeam = emptyTeam;
      this.index = -1;
    },
    loadTeams: function loadTeams() {
      var _this = this;

      axios.get('/api/v1/teams/list', {
        params: {
          page: this.page,
          size: this.pageSize
        }
      }).then(function (res) {
        if (_this.loading) _this.loading = false;

        _this.teams = res.data;
        bus.$emit('pageChanged', res.data);
      });
    },
    pageChange: function pageChange(diff) {
      this.page += diff;
    },
    addTeam: function addTeam() {
      this.currentTeam = emptyTeam;
      this.index = -1;
      jQuery('#teamModal').modal('show');
    },
    editteam: function editteam(team, index) {
      this.index = index;
      this.currentTeam = team;
      jQuery('#teamModal').modal('show');
    },
    delteam: function delteam(team, index) {
      var _this2 = this;

      //console.log(team)
      axios.post('/api/v1/teams/del', { id: team.id }).then(function (x) {
        var _x$data = x.data,
            ret = _x$data.ret,
            message = _x$data.message;

        if (ret == 0) {
          _this2.teams.data.splice(index, 1);
        } else {
          alert(message);
        }
      }).catch(function (e) {
        console.log(e);
      });
    },
    teamSaved: function teamSaved(team) {
      if (this.index !== -1) {
        this.teams.data.splice(this.index, 1, team);
      } else {
        this.teams.data.unshift(team);
      }
      jQuery('#teamModal').modal('hide');
    }
  },
  components: {
    loading: __WEBPACK_IMPORTED_MODULE_0__components_loading_vue___default.a,
    teamList: __WEBPACK_IMPORTED_MODULE_1__components_teamList_vue___default.a,
    pager: __WEBPACK_IMPORTED_MODULE_2__components_pager_vue___default.a,
    teamModal: __WEBPACK_IMPORTED_MODULE_3__components_teamModal_vue___default.a
  },
  created: function created() {
    this.loadTeams();
    bus.$on('editteam', this.editteam);
    bus.$on('delteam', this.delteam);
    bus.$on('pageChange', this.pageChange);
    bus.$on('addTeam', this.addTeam);
    bus.$on('teamSaved', this.teamSaved);
    bus.$on('modalCanceled', this.reset);
  },
  destroyed: function destroyed() {
    bus.$off('editteam', this.editteam);
    bus.$off('delteam', this.delteam);
    bus.$off('pageChange', this.pageChange);
    bus.$off('addTeam', this.addTeam);
    bus.$off('teamSaved', this.teamSaved);
  }
});

/***/ }),

/***/ "./node_modules/extract-text-webpack-plugin/dist/loader.js?{\"id\":1,\"omit\":1,\"remove\":true}!./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-3a7c16b6\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/components/teamDetail.vue":
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./node_modules/extract-text-webpack-plugin/dist/loader.js?{\"id\":1,\"omit\":1,\"remove\":true}!./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-711cb16c\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/views/team.vue":
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./node_modules/extract-text-webpack-plugin/dist/loader.js?{\"id\":1,\"omit\":1,\"remove\":true}!./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-b1c7fb96\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/components/loading.vue":
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

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

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-1424c5ee\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/teamModal.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "modal fade", attrs: { tabindex: "-1", role: "dialog" } },
    [
      _c(
        "div",
        { staticClass: "modal-dialog modal-lg", attrs: { role: "document" } },
        [
          _c("div", { staticClass: "modal-content" }, [
            _c("div", { staticClass: "modal-header" }, [
              _vm._m(0),
              _vm._v(" "),
              _c("h4", { staticClass: "modal-title" }, [
                _vm._v(_vm._s(_vm.title))
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "modal-body" }, [
              _c(
                "div",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: _vm.errors.length,
                      expression: "errors.length"
                    }
                  ],
                  staticClass: "alert alert-danger",
                  attrs: { role: "alert" }
                },
                [
                  _c(
                    "ul",
                    _vm._l(_vm.errors, function(message) {
                      return _c("li", [_vm._v(_vm._s(message))])
                    })
                  )
                ]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "team-form" }, [
                _c("div", { staticClass: "form-group" }, [
                  _c("label", { attrs: { for: "title" } }, [
                    _vm._v("团队名称")
                  ]),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.attr.title,
                        expression: "attr.title"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: { type: "text" },
                    domProps: { value: _vm.attr.title },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.attr, "title", $event.target.value)
                      }
                    }
                  })
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group" }, [
                  _c("label", { attrs: { for: "title" } }, [
                    _vm._v("团队网址")
                  ]),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.attr.website,
                        expression: "attr.website"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: { type: "url", placeholder: "http://" },
                    domProps: { value: _vm.attr.website },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.attr, "website", $event.target.value)
                      }
                    }
                  })
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group" }, [
                  _c("label", { attrs: { for: "title" } }, [
                    _vm._v("团队 LOGO")
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "media" }, [
                    _c("div", { staticClass: "media-left" }, [
                      _vm.attr.logo
                        ? _c("img", {
                            staticClass: "media-object img-thumbnail",
                            attrs: {
                              src: _vm.attr.logo,
                              width: "200",
                              height: "200"
                            }
                          })
                        : _vm._e()
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "media-body" }, [
                      _c("p", { staticClass: "help-block" }, [
                        _vm._v("可选择jpg、png格式，尺寸为200x200像素")
                      ]),
                      _vm._v(" "),
                      _c("input", {
                        staticStyle: { "margin-bottom": "10px" },
                        attrs: { type: "file", accept: "image/jpeg,image/png" },
                        on: { change: _vm.fileChanged }
                      })
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group" }, [
                  _c("label", { attrs: { for: "title" } }, [
                    _vm._v("团队介绍")
                  ]),
                  _vm._v(" "),
                  _c("textarea", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.attr.description,
                        expression: "attr.description"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: { rows: "5", placeholder: "输入团队介绍。" },
                    domProps: { value: _vm.attr.description },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.attr, "description", $event.target.value)
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("p", { staticClass: "help-block" }, [
                    _vm._v("500字以内，支持"),
                    _c("strong", [_vm._v("Markdown")]),
                    _vm._v("语法。当前字数：" + _vm._s(_vm.count) + " / 500")
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "modal-footer" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-default",
                  attrs: { type: "button", "data-dismiss": "modal" },
                  on: { click: _vm.onCancel }
                },
                [_vm._v("关闭")]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-primary",
                  attrs: { type: "button" },
                  on: { click: _vm.saveTeam }
                },
                [_vm._v("保存")]
              )
            ])
          ])
        ]
      )
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      {
        staticClass: "close",
        attrs: {
          type: "button",
          "data-dismiss": "modal",
          "aria-label": "Close"
        }
      },
      [_c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")])]
    )
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-1424c5ee", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-269c197c\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/pager.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "col-xs-12 col-sm-12 col-md-12" }, [
    _c("ul", { staticClass: "pagination" }, [
      _vm.pages.prev_page_url
        ? _c("li", [
            _c(
              "a",
              {
                attrs: { href: "#", rel: "prev" },
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    _vm.change(-1)
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
          _vm._v(_vm._s(_vm.pages.current_page) + " / " + _vm._s(_vm.totalPage))
        ])
      ]),
      _vm._v(" "),
      _vm.pages.next_page_url
        ? _c("li", [
            _c(
              "a",
              {
                attrs: { href: "#", rel: "next" },
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    _vm.change(1)
                  }
                }
              },
              [_vm._v("下一页")]
            )
          ])
        : _c("li", { staticClass: "disabled" }, [
            _c("span", [_vm._v("下一页")])
          ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-269c197c", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-2a9cfd72\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/teamList.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "row" },
    _vm._l(_vm.teams, function(team, index) {
      return _c("team-detail", {
        key: team.id,
        attrs: { team: team, index: index }
      })
    })
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-2a9cfd72", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-3a7c16b6\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/teamDetail.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "col-xs-6 col-sm-6 col-md-4 col-lg-2" }, [
    _c("div", { staticClass: "thumbnail team" }, [
      _c("img", {
        staticClass: "logo img-thumbnail",
        attrs: {
          src: _vm.team.logo,
          alt: "team.title",
          width: "200",
          height: "200"
        }
      }),
      _vm._v(" "),
      _c("div", { staticClass: "caption desc" }, [
        _c("h4", { staticClass: "title" }, [_vm._v(_vm._s(_vm.team.title))]),
        _vm._v(" "),
        _c("p", [
          _c("strong", [_vm._v("获赞：" + _vm._s(_vm.team.likes))]),
          _vm._v("人次")
        ]),
        _vm._v(" "),
        _c("p", [
          _c("strong", [_vm._v("文章：" + _vm._s(_vm.team.articles_count))]),
          _vm._v("篇")
        ]),
        _vm._v(" "),
        _c("p", { staticClass: "options" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-primary",
              attrs: { role: "button" },
              on: {
                click: function($event) {
                  _vm.edit(_vm.team)
                }
              }
            },
            [_vm._v("编辑")]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "btn btn-danger",
              attrs: { role: "button" },
              on: {
                click: function($event) {
                  _vm.delTeam(_vm.team)
                }
              }
            },
            [_vm._v("删除")]
          )
        ])
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-3a7c16b6", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-711cb16c\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/views/team.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "team-wrap" },
    [
      _vm.loading
        ? _c("loading", { attrs: { className: _vm.loading } })
        : _vm._e(),
      _vm._v(" "),
      _vm.teams.data
        ? _c("team-list", { attrs: { teams: _vm.teams.data } })
        : _vm._e(),
      _vm._v(" "),
      _vm.teams.data
        ? _c("pager", { on: { pagechange: _vm.pageChange } })
        : _vm._e(),
      _vm._v(" "),
      _c("team-modal", {
        attrs: { slot: "modal", id: "teamModal", team: _vm.currentTeam },
        slot: "modal"
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-711cb16c", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-b1c7fb96\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/loading.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row" }, [
    _c("p", { class: _vm.cls }, [_vm._v("loading...")])
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-b1c7fb96", module.exports)
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

/***/ "./resources/assets/js/components/loading.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/extract-text-webpack-plugin/dist/loader.js?{\"id\":1,\"omit\":1,\"remove\":true}!./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-b1c7fb96\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/components/loading.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/loading.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-b1c7fb96\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/loading.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
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
Component.options.__file = "resources\\assets\\js\\components\\loading.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-b1c7fb96", Component.options)
  } else {
    hotAPI.reload("data-v-b1c7fb96", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/assets/js/components/pager.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/pager.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-269c197c\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/pager.vue")
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
Component.options.__file = "resources\\assets\\js\\components\\pager.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-269c197c", Component.options)
  } else {
    hotAPI.reload("data-v-269c197c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/assets/js/components/teamDetail.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/extract-text-webpack-plugin/dist/loader.js?{\"id\":1,\"omit\":1,\"remove\":true}!./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-3a7c16b6\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/components/teamDetail.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/teamDetail.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-3a7c16b6\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/teamDetail.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
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
Component.options.__file = "resources\\assets\\js\\components\\teamDetail.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3a7c16b6", Component.options)
  } else {
    hotAPI.reload("data-v-3a7c16b6", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/assets/js/components/teamList.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/teamList.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-2a9cfd72\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/teamList.vue")
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
Component.options.__file = "resources\\assets\\js\\components\\teamList.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-2a9cfd72", Component.options)
  } else {
    hotAPI.reload("data-v-2a9cfd72", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/assets/js/components/teamModal.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/teamModal.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-1424c5ee\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/teamModal.vue")
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
Component.options.__file = "resources\\assets\\js\\components\\teamModal.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1424c5ee", Component.options)
  } else {
    hotAPI.reload("data-v-1424c5ee", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/assets/js/team.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue__ = __webpack_require__("./node_modules/vue/dist/vue.common.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_router__ = __webpack_require__("./node_modules/vue-router/dist/vue-router.esm.js");


__webpack_require__("./resources/assets/js/bootstrap.js");





__WEBPACK_IMPORTED_MODULE_0_vue___default.a.use(__WEBPACK_IMPORTED_MODULE_1_vue_router__["default"]);

var teamView = __webpack_require__("./resources/assets/js/views/team.vue");

var routes = [{ path: '/admin/team', component: teamView }];

var router = new __WEBPACK_IMPORTED_MODULE_1_vue_router__["default"]({
  mode: 'history',
  routes: routes
});

window.bus = new __WEBPACK_IMPORTED_MODULE_0_vue___default.a();

var app = new __WEBPACK_IMPORTED_MODULE_0_vue___default.a({
  el: '#teamApp',
  router: router,
  methods: {
    addTeam: function addTeam() {
      bus.$emit('addTeam');
    }
  }
});

/***/ }),

/***/ "./resources/assets/js/views/team.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/extract-text-webpack-plugin/dist/loader.js?{\"id\":1,\"omit\":1,\"remove\":true}!./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-711cb16c\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/assets/js/views/team.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/views/team.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-711cb16c\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/views/team.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
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
Component.options.__file = "resources\\assets\\js\\views\\team.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-711cb16c", Component.options)
  } else {
    hotAPI.reload("data-v-711cb16c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 1:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/team.js");


/***/ })

},[1]);