webpackJsonp([3],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/teamSelector.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "teamSelector",
  props: {
    site: {
      team_id: null
    }
  },
  data: function data() {
    return {
      selected: null,
      teams: [{ id: null, title: '请选择所属团队', disabled: true }, { id: null, title: '======================', disabled: true }]
    };
  },

  watch: {
    site: function site(val) {
      this.selected = val.team_id;
    }
  },
  methods: {
    teamChange: function teamChange() {
      bus.$emit('teamChange', this.selected);
    }
  },
  created: function created() {
    var _this = this;

    axios.get('/api/v1/teams/list').then(function (_ref) {
      var data = _ref.data;

      _this.$set(_this, 'teams', _this.teams.concat(data.data));
    });
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/views/quotaList.vue":
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

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/views/siteList.vue":
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
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'siteList',
  components: {
    teamSelector: __webpack_require__("./resources/assets/js/components/teamSelector.vue")
  },
  data: function data() {
    return {
      rows: [],
      form: {
        "name": "",
        "url": "",
        "team_id": null,
        "team": {
          "id": null,
          "title": null
        },
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
      }).catch(function (e) {
        if (e.response) {
          var data = e.response.data;

          var message = [];
          for (var key in data) {
            message.push('' + data[key]);
          }
          alert(message.join("\n"));
          return true;
        } else {
          alert(e);
        }
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
  created: function created() {
    var _this3 = this;

    this.loadSites();
    bus.$on('teamChange', function (id) {
      _this3.$set(_this3.form, 'team_id', id);
    });
  }
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

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-02c3ba33\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/teamSelector.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "select",
    {
      directives: [
        {
          name: "model",
          rawName: "v-model",
          value: _vm.selected,
          expression: "selected"
        }
      ],
      on: {
        change: [
          function($event) {
            var $$selectedVal = Array.prototype.filter
              .call($event.target.options, function(o) {
                return o.selected
              })
              .map(function(o) {
                var val = "_value" in o ? o._value : o.value
                return val
              })
            _vm.selected = $event.target.multiple
              ? $$selectedVal
              : $$selectedVal[0]
          },
          _vm.teamChange
        ]
      }
    },
    _vm._l(_vm.teams, function(ref) {
      var id = ref.id
      var title = ref.title
      var disabled = ref.disabled
      return _c(
        "option",
        { key: id, attrs: { disabled: disabled }, domProps: { value: id } },
        [_vm._v(_vm._s(title))]
      )
    })
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-02c3ba33", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-21bca6f2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/views/siteList.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row" }, [
    _c("div", { staticClass: "col-sm-9" }, [
      _c("table", { staticClass: "table table-bordered" }, [
        _vm._m(0),
        _vm._v(" "),
        _c(
          "tbody",
          _vm._l(_vm.rows, function(row, index) {
            return _c("tr", [
              _c("td", [_vm._v(_vm._s(row.id))]),
              _vm._v(" "),
              _c("td", [
                _c("a", { attrs: { href: row.url, title: row.name } }, [
                  _vm._v(_vm._s(row.name))
                ])
              ]),
              _vm._v(" "),
              _c("td", [_vm._v(_vm._s(row.team ? row.team.title : "未设定"))]),
              _vm._v(" "),
              _c("td", [_vm._v(_vm._s(row.published ? "是" : "否"))]),
              _vm._v(" "),
              _c("td", [_vm._v(_vm._s(row.last_check))]),
              _vm._v(" "),
              _c("td", [_vm._v(_vm._s(row.list_url))]),
              _vm._v(" "),
              _c("td", [
                _c(
                  "button",
                  {
                    staticClass: "btn btn-xs btn-success",
                    on: {
                      click: function($event) {
                        _vm.edit(index)
                      }
                    }
                  },
                  [_vm._v("编辑")]
                ),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn btn-xs btn-danger",
                    on: {
                      click: function($event) {
                        _vm.del(row.id)
                      }
                    }
                  },
                  [_vm._v("删除")]
                ),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn btn-xs btn-primary",
                    on: {
                      click: function($event) {
                        _vm.fetch(row.id)
                      }
                    }
                  },
                  [_vm._v("抓取")]
                )
              ])
            ])
          })
        )
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "col-sm-3" }, [
      _c("div", { staticClass: "form" }, [
        _c("div", { staticClass: "form-group" }, [
          _c("label", { staticClass: "form-label", attrs: { for: "name" } }, [
            _vm._v("名称")
          ]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.form.name,
                expression: "form.name"
              }
            ],
            staticClass: "form-control",
            attrs: { name: "name", id: "name", type: "text" },
            domProps: { value: _vm.form.name },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.$set(_vm.form, "name", $event.target.value)
              }
            }
          })
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group" }, [
          _c("label", { staticClass: "form-label", attrs: { for: "url" } }, [
            _vm._v("地址")
          ]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.form.url,
                expression: "form.url"
              }
            ],
            staticClass: "form-control",
            attrs: { name: "url", id: "url", type: "text" },
            domProps: { value: _vm.form.url },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.$set(_vm.form, "url", $event.target.value)
              }
            }
          })
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "form-group" },
          [
            _c("label", { staticClass: "form-label", attrs: { for: "team" } }, [
              _vm._v("所属团队")
            ]),
            _vm._v(" "),
            _c("team-selector", {
              staticClass: "form-control",
              attrs: { id: "team", name: "team", site: _vm.form }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c("div", { staticClass: "form-group" }, [
          _c(
            "label",
            { staticClass: "form-label", attrs: { for: "list_url" } },
            [_vm._v("列表页地址")]
          ),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.form.list_url,
                expression: "form.list_url"
              }
            ],
            staticClass: "form-control",
            attrs: { name: "list_url", id: "list_url", type: "text" },
            domProps: { value: _vm.form.list_url },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.$set(_vm.form, "list_url", $event.target.value)
              }
            }
          })
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group" }, [
          _c(
            "label",
            { staticClass: "form-label", attrs: { for: "selLink" } },
            [_vm._v("链接选择器")]
          ),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.form.sel_link,
                expression: "form.sel_link"
              }
            ],
            staticClass: "form-control",
            attrs: {
              name: "selLink",
              id: "selLink",
              type: "text",
              placeholder: "选择器对应元素href属性为详情页url"
            },
            domProps: { value: _vm.form.sel_link },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.$set(_vm.form, "sel_link", $event.target.value)
              }
            }
          })
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group" }, [
          _c(
            "label",
            { staticClass: "form-label", attrs: { for: "selTitle" } },
            [_vm._v("标题选择器")]
          ),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.form.sel_title,
                expression: "form.sel_title"
              }
            ],
            staticClass: "form-control",
            attrs: {
              name: "selTitle",
              id: "selTitle",
              type: "text",
              placeholder: "选择器对应元素innerText为标题"
            },
            domProps: { value: _vm.form.sel_title },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.$set(_vm.form, "sel_title", $event.target.value)
              }
            }
          })
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group" }, [
          _c(
            "label",
            { staticClass: "form-label", attrs: { for: "selContent" } },
            [_vm._v("内容选择器")]
          ),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.form.sel_content,
                expression: "form.sel_content"
              }
            ],
            staticClass: "form-control",
            attrs: {
              name: "selContent",
              id: "selContent",
              type: "text",
              placeholder: "选择器对应元素的innerHTML为内容"
            },
            domProps: { value: _vm.form.sel_content },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.$set(_vm.form, "sel_content", $event.target.value)
              }
            }
          })
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group" }, [
          _c("label", { staticClass: "form-label", attrs: { for: "selTag" } }, [
            _vm._v("标签选择器")
          ]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.form.sel_tag,
                expression: "form.sel_tag"
              }
            ],
            staticClass: "form-control",
            attrs: {
              name: "selTag",
              id: "selTag",
              type: "text",
              placeholder: "选择器对应元素的innerText为标签"
            },
            domProps: { value: _vm.form.sel_tag },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.$set(_vm.form, "sel_tag", $event.target.value)
              }
            }
          })
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group" }, [
          _c(
            "label",
            { staticClass: "form-label", attrs: { for: "selAuthorLink" } },
            [_vm._v("作者地址选择器")]
          ),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.form.sel_author_link,
                expression: "form.sel_author_link"
              }
            ],
            staticClass: "form-control",
            attrs: {
              name: "selAuthor",
              id: "selAuthorLink",
              type: "text",
              placeholder: "选择器对应元素的href为作者地址"
            },
            domProps: { value: _vm.form.sel_author_link },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.$set(_vm.form, "sel_author_link", $event.target.value)
              }
            }
          })
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group" }, [
          _c(
            "label",
            { staticClass: "form-label", attrs: { for: "selAuthorName" } },
            [_vm._v("作者名称选择器")]
          ),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.form.sel_author_name,
                expression: "form.sel_author_name"
              }
            ],
            staticClass: "form-control",
            attrs: {
              name: "selAuthor",
              id: "selAuthorName",
              type: "text",
              placeholder: "选择器对应元素的innerText为作者地址"
            },
            domProps: { value: _vm.form.sel_author_name },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.$set(_vm.form, "sel_author_name", $event.target.value)
              }
            }
          })
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group" }, [
          _c(
            "label",
            { staticClass: "form-label", attrs: { for: "published" } },
            [
              _vm._v("自动发布 "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.form.published,
                    expression: "form.published"
                  }
                ],
                attrs: {
                  type: "checkbox",
                  name: "published",
                  value: "true",
                  id: "published"
                },
                domProps: {
                  checked: Array.isArray(_vm.form.published)
                    ? _vm._i(_vm.form.published, "true") > -1
                    : _vm.form.published
                },
                on: {
                  change: function($event) {
                    var $$a = _vm.form.published,
                      $$el = $event.target,
                      $$c = $$el.checked ? true : false
                    if (Array.isArray($$a)) {
                      var $$v = "true",
                        $$i = _vm._i($$a, $$v)
                      if ($$el.checked) {
                        $$i < 0 &&
                          _vm.$set(_vm.form, "published", $$a.concat([$$v]))
                      } else {
                        $$i > -1 &&
                          _vm.$set(
                            _vm.form,
                            "published",
                            $$a.slice(0, $$i).concat($$a.slice($$i + 1))
                          )
                      }
                    } else {
                      _vm.$set(_vm.form, "published", $$c)
                    }
                  }
                }
              })
            ]
          )
        ])
      ]),
      _vm._v(" "),
      _c(
        "button",
        { staticClass: "btn btn-success", on: { click: _vm.checkFetch } },
        [_vm._v("测试抓取")]
      ),
      _vm._v(" "),
      _c(
        "button",
        { staticClass: "btn btn-primary", on: { click: _vm.submit } },
        [_vm._v("保存站点")]
      )
    ])
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
        _c("th", [_vm._v("名称")]),
        _vm._v(" "),
        _c("th", [_vm._v("所属团队")]),
        _vm._v(" "),
        _c("th", [_vm._v("自动发布")]),
        _vm._v(" "),
        _c("th", [_vm._v("最后采集时间")]),
        _vm._v(" "),
        _c("th", [_vm._v("列表地址")]),
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
    require("vue-hot-reload-api")      .rerender("data-v-21bca6f2", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-531da319\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/views/quotaList.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
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
    _c("table", { staticClass: "table table-bordered" }, [
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
              _c("a", { attrs: { href: row.site_url, title: row.site_name } }, [
                _vm._v(_vm._s(row.site_name))
              ])
            ]),
            _vm._v(" "),
            _c("td", [_vm._v(_vm._s(row.team ? row.team.title : "未设定"))]),
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
                [_vm._v("发布")]
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
    ]),
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
    require("vue-hot-reload-api")      .rerender("data-v-531da319", module.exports)
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

/***/ "./resources/assets/js/components/teamSelector.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/components/teamSelector.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-02c3ba33\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/components/teamSelector.vue")
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
Component.options.__file = "resources\\assets\\js\\components\\teamSelector.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-02c3ba33", Component.options)
  } else {
    hotAPI.reload("data-v-02c3ba33", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/assets/js/quotas.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue__ = __webpack_require__("./node_modules/vue/dist/vue.common.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue__);
__webpack_require__("./resources/assets/js/bootstrap.js");



var quotaList = __webpack_require__("./resources/assets/js/views/quotaList.vue");
var siteList = __webpack_require__("./resources/assets/js/views/siteList.vue");

window.bus = new __WEBPACK_IMPORTED_MODULE_0_vue___default.a();

var app = new __WEBPACK_IMPORTED_MODULE_0_vue___default.a({
  el: '#quotaApp',
  components: {
    quotaList: quotaList,
    siteList: siteList
  }
});

/***/ }),

/***/ "./resources/assets/js/views/quotaList.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/views/quotaList.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-531da319\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/views/quotaList.vue")
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
Component.options.__file = "resources\\assets\\js\\views\\quotaList.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-531da319", Component.options)
  } else {
    hotAPI.reload("data-v-531da319", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/assets/js/views/siteList.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/views/siteList.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-21bca6f2\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/views/siteList.vue")
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
Component.options.__file = "resources\\assets\\js\\views\\siteList.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-21bca6f2", Component.options)
  } else {
    hotAPI.reload("data-v-21bca6f2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/assets/sass/backend.scss":
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/assets/sass/vue.scss":
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("./resources/assets/js/quotas.js");
__webpack_require__("./resources/assets/sass/vue.scss");
module.exports = __webpack_require__("./resources/assets/sass/backend.scss");


/***/ })

},[0]);