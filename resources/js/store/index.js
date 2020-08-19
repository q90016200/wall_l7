/* eslint-disable no-console */
import Vue from 'vue'
import Vuex from 'vuex'

// import axios from 'axios'
import User from "../apis/User";

Vue.use(Vuex)

export default new Vuex.Store({
    state: { // 狀態儲存的物件
        auth: false,
        user: {
            "type": null,
            // "token": null,
            "name": null,
        },
        // test: null,
    },
    mutations: { // 更新狀態資料的方法。
        // 用戶登錄成功，存儲 token 並設置
        logined(state) {
            state.auth = true;
            // state.user.token = token;
            // localStorage.token = token;
            // axios.defaults.headers.common = { 'Authorization': `bearer ${token}` }
        },
        // 用戶刷新 token 成功，使用新的 token 替換掉本地的 token
        refreshToken(state, token) {
            state.user.token = token;
            localStorage.token = token;
            axios.defaults.headers.common = { 'Authorization': `bearer ${token}` }
        },
        // 登錄成功後，保存用戶資訊
        profile(state, data) {
            // state.user.type = data.type;
            state.user.name = data.name;
        },
        // 用戶登出，清除用戶數據
        logout(state) {
            state.logined = false;
            state.user.type = null;
            state.user.name = null;
            state.user.token = null;

            localStorage.removeItem('token');
            axios.defaults.headers.common['Authorization'] = "";
        }
    },
    actions: {  // 類似 Mutations，但是 Actions 是呼叫 Mutations，且可支援非同步呼叫。
        // 登錄成功後保存用戶信息
        logined({ dispatch, commit }, token) {

            commit('logined');
            dispatch('profile');

        },
        // 登錄成功後使用 token 拉取用戶的信息
        profile({ commit, dispatch }) {
            // User.profile.then(response => {
            //     if (response.status == 200) {
            //         commit('profile', response.data);
            //     }
            // });
            User.profile().then((response) => {
                if (response.status == 200) {
                    commit('profile', response.data.data);
                }
            });
        },
        // 用戶登出，清除用戶資料並重定向至登錄頁面
        logout({ commit }) {
            axios.post('/api/auth/logout', {}).then(() => {
                commit('logout');
                // Vue.$router.push({ name: 'login' });
            });

        },
        // 將刷新的 token 保存至本地
        refreshToken({ commit }) {
            return new Promise(function (resolve, reject) {
                axios.post('/api/auth/refresh', {}).then((respond) => {
                    if (respond.status == 200) {
                        let token = respond.data.access_token
                        commit('refreshToken', token)
                        resolve();
                    } else {
                        reject();
                    }
                }).catch(function () {
                    commit('logout');
                });
            });

        },
        // test({ state }, payload){
        //     state.test = payload;
        // }
    },
    getters: {
        logined: function (state) {
            return state.auth;
        },
        getUserProfile: function (state) {
            return state.user;
        }
    },
    modules: { // 用於分割 Vuex 的區塊。
    }
})
