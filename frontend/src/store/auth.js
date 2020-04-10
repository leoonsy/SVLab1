import AuthModule from '../libs/AuthModule';
export default {
    state: {
        userInfo: {} //name, role
    },
    mutations: {
        setUserInfo(state, info) {
            state.userInfo = info;
        },
        clearUserInfo(state) {
            state.info = {};
        }
    },
    actions: {
        async login({ dispatch }, { name, password }) {
            await AuthModule.login(name, password);
            dispatch('updateUserInfo');
        },
        async register(context, { password, name }) {
            await AuthModule.register(name, password);
        },
        async updateUserInfo({ commit }) {
            const userInfo = await AuthModule.getUserInfo();
            commit('setUserInfo', userInfo);
        },
        async logout({ commit }) {
            await AuthModule.logout();
            commit('clearUserInfo');
        }
    },
    getters: {
        userInfo: s => s.userInfo
    }
}