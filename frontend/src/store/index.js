import Vue from 'vue'
import Vuex from 'vuex'
import auth from './auth'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    loading: false
  },
  mutations: {
    setLoading(state, bool) {
      state.loading = bool;
    }
  },
  actions: {
  },
  getters: {
    loading: s => s.loading
  },
  modules: {
    auth
  }
})
