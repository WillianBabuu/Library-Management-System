import LocalStorage from "@models/enums/local-storage";

export default {
    namespaced: true,
    state: {
        sidebarIsOpen: false,
        activeMenuItem: localStorage.getItem(LocalStorage.SIDEBAR_ACTIVE_MENU_ITEM) || 'dashboard',
        activeSettingMenuItem: localStorage.getItem(LocalStorage.SETTING_ACTIVE_MENU_ITEM) || 'my-profile',
        listOfSettingMenuItem: [
            { page: 'my-profile', icon: 'UserIcon', label: 'Account Settings' },
            { page: 'company-info', icon: 'OfficeBuildingIcon', label: 'Company Information' },
            { page: 'store-list', icon: 'HomeIcon', label: 'Stores' },
            { page: 'system-setting-list', icon: 'CogIcon', label: 'System Settings' },
            { page: 'config-list', icon: 'TableIcon', label: 'Configs' },
            { page: 'user-role-list', icon: 'UserGroupIcon', label: 'User Roles' },
            { page: 'taxes', icon: 'CheckCircleIcon', label: 'Taxes' },
            { page: 'attributes', icon: 'CheckCircleIcon', label: 'Attributes' },
            { page: 'payment-mode-list', icon: 'CreditCardIcon', label: 'Payment Modes' },
            { page: 'category-list', icon: 'ClipboardListIcon', label: 'Categories' },
        ],
        activeReportMenuItem: localStorage.getItem(LocalStorage.REPORT_ACTIVE_MENU_ITEM) || 'report-store',
        listOfReportMenuItem: [
            { page: 'report-store', icon: 'ChartBarIcon', label: 'Item Balance' },
            { page: 'report-two', icon: 'UserIcon', label: 'Report Two' },
            { page: 'report-three', icon: 'UserIcon', label: 'Report Three' },
        ],
    },
    getters: {
        sidebarIsOpen: state => state.sidebarIsOpen,
    },
    actions: {
        sidebarOpenClose({ commit }, sidebarIsOpen) {
            commit('SET_SIDEBAR_IS_OPEN', sidebarIsOpen);
        },
    },
    mutations: {
        SET_SIDEBAR_IS_OPEN(state, sidebarIsOpen) {
            state.sidebarIsOpen = sidebarIsOpen;
            console.log('SET SIDEBAR IS OPEN : ' + state.sidebarIsOpen);
        },
        SET_ACTIVE_MENU_ITEM: (state, menuItem) => {
            state.activeMenuItem = menuItem;
            localStorage.setItem(LocalStorage.SIDEBAR_ACTIVE_MENU_ITEM, state.activeMenuItem);
            if (menuItem !== 'settings') {
                state.activeSettingMenuItem = 'my-profile';
                localStorage.setItem(LocalStorage.SETTING_ACTIVE_MENU_ITEM, state.activeSettingMenuItem);
            }
        },
        SIDEBAR_REPORT_ACTIVE_MENU_ITEM: (state, menuItem) => {
            state.activeMenuItem = menuItem;
            localStorage.setItem(LocalStorage.SIDEBAR_REPORT_ACTIVE_MENU_ITEM, state.activeMenuItem);
            if (menuItem !== 'reports') {
                state.activeSettingMenuItem = 'report-one';
                localStorage.setItem(LocalStorage.REPORT_ACTIVE_MENU_ITEM, state.activeReportMenuItem);
            }
        },
        SET_ACTIVE_SETTING_MENU_ITEM: (state, menuItem) => {
            state.activeSettingMenuItem = menuItem;
            localStorage.setItem(LocalStorage.SETTING_ACTIVE_MENU_ITEM, state.activeSettingMenuItem);
        },
        SET_ACTIVE_REPORT_MENU_ITEM: (state, menuItem) => {
            state.activeReportMenuItem = menuItem;
            localStorage.setItem(LocalStorage.REPORT_ACTIVE_MENU_ITEM, state.activeReportMenuItem);
        }
    },
    modules: {},
};