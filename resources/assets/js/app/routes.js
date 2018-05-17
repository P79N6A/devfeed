/**
 * meta参数解析
 * hideLeft: 是否隐藏左侧菜单，单页菜单为true
 * module: 菜单所属模块
 * menu: 所属菜单，用于判断三级菜单是否显示高亮，如菜单列表、添加菜单、编辑菜单都是'menu'，用户列表、添加用户、编辑用户都是'user'，如此类推
 */
const MyView = require('../components/MyView.vue');
const error404 = require('../components/app/error404');


const Home = require('../components/app/home');

const alist = require('../components/app/alist');

const adetail = require('../components/app/adetail');

const tlist = require('../components/app/tlist');
const tdetail = require('../components/app/tdetail');

const routes = [
    {
        path: '/',
        component: Home,
        children: [
                    { path: 'hot', component: alist},
                    { path: 'hot/:id', component: alist},
                    { path: '', redirect: '/new'},
                    { path: 'new', component: alist},
                    { path: 'new/:id', component: alist},
                    { path: 'article/:id', component: adetail},
                    { path: 'teams', component:tlist},
                    { path: 'teams/:id', component:tlist},
                    { path: 'team/:tid', component:tdetail},
                    { path: 'team/:tid/:pid', component:tdetail},

        ]
    },
    { path: '/error404', component: error404}
];
export default routes;