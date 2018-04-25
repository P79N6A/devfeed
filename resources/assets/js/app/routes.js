/**
 * meta参数解析
 * hideLeft: 是否隐藏左侧菜单，单页菜单为true
 * module: 菜单所属模块
 * menu: 所属菜单，用于判断三级菜单是否显示高亮，如菜单列表、添加菜单、编辑菜单都是'menu'，用户列表、添加用户、编辑用户都是'user'，如此类推
 */
const MyView = require('../components/MyView.vue');
const Example = require('../components/example');


const Home = require('../components/app/home');

const alist = require('../components/app/alist');


const routes = [
    {
        path: '/',
        component: Home,
        children: [
                    // { path: '', component: alist},
                    { path: 'hot', component: alist},
                    { path: 'hot/:id', component: alist},
                    { path: '', redirect: '/new'},
                    { path: 'new', component: alist},
                    { path: 'new/:id', component: alist},

                    // { path: '/:id', component: alist},
                    // { path: '/new', component: alist },
                    // { path: '/hot/:id', component: alist},
                    // {path: '/hot/abc', component: alist}

        ]
    },
    { path: '/example', component: Example}
];
export default routes;