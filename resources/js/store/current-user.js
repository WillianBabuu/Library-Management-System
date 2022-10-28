import LocalStorage from "@models/enums/local-storage";

export default {
    namespaced: true,
    state: {
        user: {
            data: localStorage.getItem(LocalStorage.USER),
            company: localStorage.getItem(LocalStorage.COMPANY),
            company_id: localStorage.getItem(LocalStorage.COMPANY_ID),
            token: localStorage.getItem(LocalStorage.TOKEN),
            refresh_token: localStorage.getItem(LocalStorage.REFRESH_TOKEN),
        }
    },
    getters: { },
    actions: { },
    mutations: {
        USER_LOGIN: (state, data) => {
            if(data.user) { data.user = JSON.stringify(data.user); }
            state.user.data = data.user;
            localStorage.setItem(LocalStorage.USER, data.user);
            state.user.token = data.token;
            localStorage.setItem(LocalStorage.TOKEN, data.token);
            state.user.refresh_token = data.refresh_token;
            localStorage.setItem(LocalStorage.REFRESH_TOKEN, data.refresh_token);
        },
        USER_LOGOUT: (state) => {
            state.user.data = null;
            localStorage.setItem(LocalStorage.USER, null);
            state.user.company = null;
            localStorage.setItem(LocalStorage.COMPANY, null);
            state.user.token = null;
            localStorage.setItem(LocalStorage.TOKEN, null);
            state.user.refresh_token = null;
            localStorage.setItem(LocalStorage.REFRESH_TOKEN, null);
        },
        SET_COMPANY: (state, company) => {
            state.user.company_id = company.id;
            if(company) { company = JSON.stringify(company); }
            state.user.company = company;
            localStorage.setItem(LocalStorage.COMPANY, company);
            localStorage.setItem(LocalStorage.COMPANY_ID, state.user.company_id);
        },
    },
    modules: {},
};
