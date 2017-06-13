webpackJsonp([2],{

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

/***/ 15:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_router__ = __webpack_require__(6);
__webpack_require__(5);

window.Vue = __webpack_require__(3);


Vue.use(__WEBPACK_IMPORTED_MODULE_0_vue_router__["default"]);

var index = __webpack_require__(45);

var routes = [{ path: '/', component: index }];

var router = new __WEBPACK_IMPORTED_MODULE_0_vue_router__["default"]({
  routes: routes
});

var app = new Vue({
  el: '#teamApp',
  router: router
});

/***/ }),

/***/ 42:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(15);


/***/ }),

/***/ 44:
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

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "teamList",
  data: function data() {
    return {
      teams: []
    };
  },

  methods: {
    loadTeams: function loadTeams() {
      var _this = this;

      axios.get('http://fedn.local/api/v1/teams/list').then(function (res) {
        _this.teams = res.data;
      });
    },
    edit: function edit(index) {},
    del: function del(id) {}
  },
  mounted: function mounted() {
    this.loadTeams();
  }
});

/***/ }),

/***/ 45:
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(12)(
  /* script */
  __webpack_require__(44),
  /* template */
  __webpack_require__(46),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "E:\\codes\\fedn\\resources\\assets\\js\\views\\teamList.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] teamList.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6b6dfc30", Component.options)
  } else {
    hotAPI.reload("data-v-6b6dfc30", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),

/***/ 46:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('table', {
    staticClass: "table table-bordered"
  }, [_vm._m(0), _vm._v(" "), _c('tbody', _vm._l((_vm.teams), function(row, index) {
    return _c('tr', [_c('td', [_vm._v(_vm._s(row.id))]), _vm._v(" "), _c('td', [_c('a', {
      attrs: {
        "href": row.website,
        "title": row.title
      }
    }, [_vm._v(_vm._s(row.title))])]), _vm._v(" "), _c('td', [_c('img', {
      attrs: {
        "src": row.logo,
        "width": "80",
        "height": "80"
      }
    })]), _vm._v(" "), _c('td', {
      domProps: {
        "innerHTML": _vm._s(row.description_html)
      }
    }), _vm._v(" "), _c('td', [_vm._v(_vm._s(row.likes))]), _vm._v(" "), _c('td', [_c('button', {
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
    }, [_vm._v("删除")])])])
  }))])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('thead', {
    staticClass: "bg-primary"
  }, [_c('tr', [_c('th', [_vm._v("ID")]), _vm._v(" "), _c('th', [_vm._v("名称")]), _vm._v(" "), _c('th', [_vm._v("logo")]), _vm._v(" "), _c('th', [_vm._v("简介")]), _vm._v(" "), _c('th', [_vm._v("赞")]), _vm._v(" "), _c('th', [_vm._v("操作")])])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-6b6dfc30", module.exports)
  }
}

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

},[42]);