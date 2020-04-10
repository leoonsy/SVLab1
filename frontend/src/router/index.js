import Vue from 'vue'
import VueRouter from 'vue-router'
import AuthModule from '@/libs/AuthModule'
import store from '@/store'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'root',
    component: () => import('@/views/Root.vue')
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('@/views/Login.vue')
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('@/views/Register.vue')
  },
  {
    path: '/profile',
    name: 'profile',
    component: () => import('@/views/Profile.vue')
  },
  {
    path: '/admin',
    name: 'admin',
    component: () => import('@/views/Admin.vue')
  },
  {
    path: '*',
    name: 'error',
    component: () => import('@/views/Error.vue')
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
  store.commit('setLoading', true);
  next();
});

router.afterEach(() => {
  store.commit('setLoading', false);
});

router.beforeEach(async (to, from, next) => {
  if (to.name == "error") {
    next();
    return;
  };

  const userInfo = await AuthModule.getUserInfo();
  store.commit("setUserInfo", userInfo);
  if (userInfo.accessPages.includes(to.name))
    next();
  else {
    if (userInfo.role == "guest") next({ name: "login" });
    else next({ name: "root" });
  }
});

export default router
