import Vue from 'vue'
import VueRouter from 'vue-router'
// import Home from '../views/Home.vue'
import Posts from '../posts.vue'
import PostShow from '../postShow.vue'

Vue.use(VueRouter)

const routes = [
    // {
    //     path: '/',
    //     name: 'home',
    //     component: Home
    // },
    {
        path: '/',
        name: 'posts',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: Posts,
        // children: [
        //     // 当 /posts/ 匹配成功，
        //     // post 会被渲染在 posts 的 <router-view> 中
        //     {
        //         path: ':post_id',
        //         component: PostShow,
        //         name: 'postShow'
        //     },

        //     // ...其他子路由
        // ]
    },
    {
        path: '/:post_id',
        name: 'postShow',
        component: PostShow,
    }
]

const router = new VueRouter({
    routes
})

export default router
