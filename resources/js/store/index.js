import { createStore } from "vuex";
import currentUser from "@store/current-user.js";
import sidebar from "@store/sidebar.js";

const modules = {
    currentUser,
    sidebar,
};

const store = createStore({
    strict: true,
    modules,
    state: {
        showWaitingLoader: false,
        optionWaitingLoader: '1',
    },
    mutations: {
        SHOW_WAITING_LOADER: (state, showLoader) => {
            state.showWaitingLoader = showLoader;
            state.optionWaitingLoader = 'base-loader-option-' + (Math.floor(Math.random() * (12 - 1 + 1)) + 1);
            console.log('Current Loader : ' + state.optionWaitingLoader);
        },
    }
});

/*for(const moduleName of Object.keys(modules)) {
    if(modules[moduleName].action && modules[moduleName].action.initStore) {
        store.dispatch('${moduleName}/initStore');
    }
}*/

export default store;
