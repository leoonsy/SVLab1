import Vue from 'vue'
import VueRouter from 'vue-router'
import AuthModule from '@/libs/AuthModule'
import store from '@/store'
import EmptyLayout from '@/layouts/EmptyLayout'
import MainLayout from '@/layouts/MainLayout'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'root',
    component: () => import('@/views/Root.vue'),
    meta: {
      layout: MainLayout
    }
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('@/views/Login.vue'),
    meta: {
      layout: EmptyLayout
    }
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('@/views/Register.vue'),
    meta: {
      layout: EmptyLayout
    }
  },
  {
    path: '/profile',
    name: 'profile',
    component: () => import('@/views/Profile.vue'),
    meta: {
      layout: MainLayout
    }
  },
  {
    path: '/admin',
    name: 'admin',
    component: () => import('@/views/Admin.vue'),
    meta: {
      layout: MainLayout
    }
  },
  {
    path: '*',
    name: 'error',
    component: () => import('@/views/Error.vue'),
    meta: {
      layout: EmptyLayout
    }
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

  try {
    var userInfo = await AuthModule.getUserInfo();
  }
  catch (e) {
    next({ name: "error", params: { code: '500' } });
    return;
  }

  store.commit("setUserInfo", userInfo);
  if (userInfo.accessPages.includes(to.name))
    next();
  else {
    if (userInfo.role == "guest") next({ name: "login" });
    else next({ name: "root" });
  }
});

export default router
