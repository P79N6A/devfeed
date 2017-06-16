webpackJsonp([0],[
/* 0 */,
/* 1 */
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// this module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
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
/* 2 */,
/* 3 */,
/* 4 */,
/* 5 */
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
  window.axios = __webpack_require__(2);
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
/* 6 */
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function(useSourceMap) {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		return this.map(function (item) {
			var content = cssWithMappingToString(item, useSourceMap);
			if(item[2]) {
				return "@media " + item[2] + "{" + content + "}";
			} else {
				return content;
			}
		}).join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};

function cssWithMappingToString(item, useSourceMap) {
	var content = item[1] || '';
	var cssMapping = item[3];
	if (!cssMapping) {
		return content;
	}

	if (useSourceMap && typeof btoa === 'function') {
		var sourceMapping = toComment(cssMapping);
		var sourceURLs = cssMapping.sources.map(function (source) {
			return '/*# sourceURL=' + cssMapping.sourceRoot + source + ' */'
		});

		return [content].concat(sourceURLs).concat([sourceMapping]).join('\n');
	}

	return [content].join('\n');
}

// Adapted from convert-source-map (MIT)
function toComment(sourceMap) {
	// eslint-disable-next-line no-undef
	var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));
	var data = 'sourceMappingURL=data:application/json;charset=utf-8;base64,' + base64;

	return '/*# ' + data + ' */';
}


/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__(65)

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction) {
  isProduction = _isProduction

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[data-vue-ssr-id~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),
/* 8 */,
/* 9 */,
/* 10 */,
/* 11 */,
/* 12 */,
/* 13 */,
/* 14 */,
/* 15 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_router__ = __webpack_require__(8);


__webpack_require__(5);





__WEBPACK_IMPORTED_MODULE_0_vue___default.a.use(__WEBPACK_IMPORTED_MODULE_1_vue_router__["default"]);

var teamView = __webpack_require__(53);

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
/* 16 */,
/* 17 */,
/* 18 */,
/* 19 */,
/* 20 */,
/* 21 */,
/* 22 */,
/* 23 */,
/* 24 */,
/* 25 */,
/* 26 */,
/* 27 */,
/* 28 */,
/* 29 */,
/* 30 */,
/* 31 */,
/* 32 */,
/* 33 */,
/* 34 */
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
/* 35 */
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
/* 36 */
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
/* 37 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__teamDetail_vue__ = __webpack_require__(48);
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
/* 38 */
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
            bus.$emit('teamSaved', result.message);
        }
      }).catch(function (e) {
        _this2.errors = [e.message];
      });
    }
  }
});

/***/ }),
/* 39 */,
/* 40 */,
/* 41 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_loading_vue__ = __webpack_require__(46);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_loading_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__components_loading_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_teamList_vue__ = __webpack_require__(49);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_teamList_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__components_teamList_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_pager_vue__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_pager_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__components_pager_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_teamModal_vue__ = __webpack_require__(50);
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

      axios.get('http://fedn.local/api/v1/teams/list', {
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
      //console.log(team)
      this.teams.data.splice(index, 1);
      this.index = -1;
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
/* 42 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(6)(undefined);
// imports


// module
exports.push([module.i, "\n.team .logo {\n    width: 200px;\n    height: 200px;\n    max-width:200px;\n    max-height:200px;\n    min-height:200px;\n    min-width:200px;\n}\n.team .title {\n    font-size: 20px;\n    font-weight:bold;\n    width: 100%;\n    word-wrap: normal;\n    white-space: nowrap;\n    overflow: hidden;\n    text-overflow: ellipsis;\n    text-overflow-ellipsis: '...';\n}\n.team .intro {\n    height: 90px;\n    margin-bottom: 10px;\n    overflow: hidden;\n}\n", ""]);

// exports


/***/ }),
/* 43 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(6)(undefined);
// imports


// module
exports.push([module.i, "\n.cls {\n    padding:50px 100px;\n    text-align:center;\n    margin:auto;\n}\n", ""]);

// exports


/***/ }),
/* 44 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(6)(undefined);
// imports


// module
exports.push([module.i, "\n.team-wrap {\n    padding: 0 15px;\n    min-width: 500px;\n}\n", ""]);

// exports


/***/ }),
/* 45 */,
/* 46 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(63)
}
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(34),
  /* template */
  __webpack_require__(56),
  /* styles */
  injectStyle,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "E:\\codes\\fedn\\resources\\assets\\js\\components\\loading.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] loading.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-575d16e2", Component.options)
  } else {
    hotAPI.reload("data-v-575d16e2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 47 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(35),
  /* template */
  __webpack_require__(58),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "E:\\codes\\fedn\\resources\\assets\\js\\components\\pager.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] pager.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7b5e5a56", Component.options)
  } else {
    hotAPI.reload("data-v-7b5e5a56", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 48 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(62)
}
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(36),
  /* template */
  __webpack_require__(54),
  /* styles */
  injectStyle,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "E:\\codes\\fedn\\resources\\assets\\js\\components\\teamDetail.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] teamDetail.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3d2fa7ea", Component.options)
  } else {
    hotAPI.reload("data-v-3d2fa7ea", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 49 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(37),
  /* template */
  __webpack_require__(60),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "E:\\codes\\fedn\\resources\\assets\\js\\components\\teamList.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] teamList.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-b7d45350", Component.options)
  } else {
    hotAPI.reload("data-v-b7d45350", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 50 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(38),
  /* template */
  __webpack_require__(59),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "E:\\codes\\fedn\\resources\\assets\\js\\components\\teamModal.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] teamModal.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-a8e03e3a", Component.options)
  } else {
    hotAPI.reload("data-v-a8e03e3a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 51 */,
/* 52 */,
/* 53 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(64)
}
var Component = __webpack_require__(1)(
  /* script */
  __webpack_require__(41),
  /* template */
  __webpack_require__(57),
  /* styles */
  injectStyle,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)
Component.options.__file = "E:\\codes\\fedn\\resources\\assets\\js\\views\\team.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] team.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-57d1052a", Component.options)
  } else {
    hotAPI.reload("data-v-57d1052a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 54 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "col-xs-6 col-sm-6 col-md-4 col-lg-2"
  }, [_c('div', {
    staticClass: "thumbnail team"
  }, [_c('img', {
    staticClass: "logo img-thumbnail",
    attrs: {
      "src": _vm.team.logo,
      "alt": "team.title",
      "width": "200",
      "height": "200"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "caption desc"
  }, [_c('h3', {
    staticClass: "title"
  }, [_vm._v(_vm._s(_vm.team.title))]), _vm._v(" "), _c('p', [_c('strong', [_vm._v("获赞：" + _vm._s(_vm.team.likes))]), _vm._v("人次")]), _vm._v(" "), _c('p', [_c('strong', [_vm._v("文章：" + _vm._s(Math.round(Math.random() * 1000)))]), _vm._v("篇")]), _vm._v(" "), _c('p', {
    staticClass: "options"
  }, [_c('button', {
    staticClass: "btn btn-primary",
    attrs: {
      "role": "button"
    },
    on: {
      "click": function($event) {
        _vm.edit(_vm.team)
      }
    }
  }, [_vm._v("编辑")]), _vm._v(" "), _c('button', {
    staticClass: "btn btn-danger",
    attrs: {
      "role": "button"
    },
    on: {
      "click": function($event) {
        _vm.delTeam(_vm.team)
      }
    }
  }, [_vm._v("删除")])])])])])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-3d2fa7ea", module.exports)
  }
}

/***/ }),
/* 55 */,
/* 56 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "row"
  }, [_c('p', {
    class: _vm.cls
  }, [_vm._v("loading...")])])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-575d16e2", module.exports)
  }
}

/***/ }),
/* 57 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "team-wrap"
  }, [(_vm.loading) ? _c('loading', {
    attrs: {
      "className": _vm.loading
    }
  }) : _vm._e(), _vm._v(" "), (_vm.teams.data) ? _c('team-list', {
    attrs: {
      "teams": _vm.teams.data
    }
  }) : _vm._e(), _vm._v(" "), (_vm.teams.data) ? _c('pager', {
    on: {
      "pagechange": _vm.pageChange
    }
  }) : _vm._e(), _vm._v(" "), _c('team-modal', {
    attrs: {
      "id": "teamModal",
      "team": _vm.currentTeam
    },
    slot: "modal"
  })], 1)
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-57d1052a", module.exports)
  }
}

/***/ }),
/* 58 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "col-xs-12 col-sm-12 col-md-12"
  }, [_c('ul', {
    staticClass: "pagination"
  }, [(_vm.pages.prev_page_url) ? _c('li', [_c('a', {
    attrs: {
      "href": "#",
      "rel": "prev"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.change(-1)
      }
    }
  }, [_vm._v("上一页")])]) : _c('li', {
    staticClass: "disabled"
  }, [_c('span', [_vm._v("上一页")])]), _vm._v(" "), _c('li', {
    staticClass: "disabled"
  }, [_c('span', [_vm._v(_vm._s(_vm.pages.current_page) + " / " + _vm._s(_vm.totalPage))])]), _vm._v(" "), (_vm.pages.next_page_url) ? _c('li', [_c('a', {
    attrs: {
      "href": "#",
      "rel": "next"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.change(1)
      }
    }
  }, [_vm._v("下一页")])]) : _c('li', {
    staticClass: "disabled"
  }, [_c('span', [_vm._v("下一页")])])])])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-7b5e5a56", module.exports)
  }
}

/***/ }),
/* 59 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "modal fade",
    attrs: {
      "tabindex": "-1",
      "role": "dialog"
    }
  }, [_c('div', {
    staticClass: "modal-dialog modal-lg",
    attrs: {
      "role": "document"
    }
  }, [_c('div', {
    staticClass: "modal-content"
  }, [_c('div', {
    staticClass: "modal-header"
  }, [_vm._m(0), _vm._v(" "), _c('h4', {
    staticClass: "modal-title"
  }, [_vm._v(_vm._s(_vm.title))])]), _vm._v(" "), _c('div', {
    staticClass: "modal-body"
  }, [_c('ul', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.errors.length),
      expression: "errors.length"
    }],
    staticClass: "alert alert-danger",
    attrs: {
      "role": "alert"
    }
  }, _vm._l((_vm.errors), function(message) {
    return _c('li', [_vm._v(_vm._s(message))])
  })), _vm._v(" "), _c('div', {
    staticClass: "team-form"
  }, [_c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    attrs: {
      "for": "title"
    }
  }, [_vm._v("团队名称")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.attr.title),
      expression: "attr.title"
    }],
    staticClass: "form-control",
    attrs: {
      "type": "text"
    },
    domProps: {
      "value": (_vm.attr.title)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.attr.title = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    attrs: {
      "for": "title"
    }
  }, [_vm._v("团队网址")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.attr.website),
      expression: "attr.website"
    }],
    staticClass: "form-control",
    attrs: {
      "type": "url",
      "placeholder": "http://"
    },
    domProps: {
      "value": (_vm.attr.website)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.attr.website = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    attrs: {
      "for": "title"
    }
  }, [_vm._v("团队 LOGO")]), _vm._v(" "), _c('div', {
    staticClass: "media"
  }, [_c('div', {
    staticClass: "media-left"
  }, [(_vm.attr.logo) ? _c('img', {
    staticClass: "media-object img-thumbnail",
    attrs: {
      "src": _vm.attr.logo,
      "width": "200",
      "height": "200"
    }
  }) : _vm._e()]), _vm._v(" "), _c('div', {
    staticClass: "media-body"
  }, [_c('p', {
    staticClass: "help-block"
  }, [_vm._v("可选择jpg、png格式，尺寸为200x200像素")]), _vm._v(" "), _c('input', {
    staticStyle: {
      "margin-bottom": "10px"
    },
    attrs: {
      "type": "file",
      "accept": "image/jpeg,image/png"
    },
    on: {
      "change": _vm.fileChanged
    }
  })])])]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    attrs: {
      "for": "title"
    }
  }, [_vm._v("团队介绍")]), _vm._v(" "), _c('textarea', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.attr.description),
      expression: "attr.description"
    }],
    staticClass: "form-control",
    attrs: {
      "rows": "5",
      "placeholder": "输入团队介绍。"
    },
    domProps: {
      "value": (_vm.attr.description)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.attr.description = $event.target.value
      }
    }
  }), _vm._v(" "), _c('p', {
    staticClass: "help-block"
  }, [_vm._v("500字以内，支持"), _c('strong', [_vm._v("Markdown")]), _vm._v("语法。当前字数：" + _vm._s(_vm.count) + " / 500")])])])]), _vm._v(" "), _c('div', {
    staticClass: "modal-footer"
  }, [_c('button', {
    staticClass: "btn btn-default",
    attrs: {
      "type": "button",
      "data-dismiss": "modal"
    },
    on: {
      "click": _vm.onCancel
    }
  }, [_vm._v("关闭")]), _vm._v(" "), _c('button', {
    staticClass: "btn btn-primary",
    attrs: {
      "type": "button"
    },
    on: {
      "click": _vm.saveTeam
    }
  }, [_vm._v("保存")])])])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('button', {
    staticClass: "close",
    attrs: {
      "type": "button",
      "data-dismiss": "modal",
      "aria-label": "Close"
    }
  }, [_c('span', {
    attrs: {
      "aria-hidden": "true"
    }
  }, [_vm._v("×")])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-a8e03e3a", module.exports)
  }
}

/***/ }),
/* 60 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "row"
  }, _vm._l((_vm.teams), function(team, index) {
    return _c('team-detail', {
      key: team.id,
      attrs: {
        "team": team,
        "index": index
      }
    })
  }))
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-b7d45350", module.exports)
  }
}

/***/ }),
/* 61 */,
/* 62 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(42);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(7)("5391759b", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-3d2fa7ea\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./teamDetail.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-3d2fa7ea\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./teamDetail.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 63 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(43);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(7)("5b612e3b", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-575d16e2\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./loading.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-575d16e2\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./loading.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 64 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(44);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(7)("46300cc0", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-57d1052a\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./team.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-57d1052a\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./team.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 65 */
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


/***/ }),
/* 66 */,
/* 67 */,
/* 68 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(15);


/***/ })
],[68]);