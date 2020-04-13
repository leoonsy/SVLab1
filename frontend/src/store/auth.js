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
        async login({ dispatch }, { username, password }) {
            await AuthModule.login(username, password);
            dispatch('updateUserInfo');
        },
        async register(context, { password, username }) {
            await AuthModule.register(username, password);
        },
        async updateUserInfo({ commit }) {
            const userInfo = await AuthModule.getUserInfo();
            commit('setUserInfo', userInfo);
        },
        async logout({ commit }) {
            await AuthModule.logout();
        }
    },
    getters: {
        userInfo: s => s.userInfo
    }
}