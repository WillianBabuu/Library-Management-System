import baseService from "@services/base-service.js";

export default {
    csrfCookie() {
        return baseService.get('/sanctum/csrf-cookie');
    },
    async register(data, okFunction, showWaitingDialog = true) {
        await baseService.appPost('/register', data, okFunction, showWaitingDialog);
    },
    async login(data, okFunction, showWaitingDialog = true) {
        await baseService.appPost('/login', data, okFunction, showWaitingDialog);
    },
    async logout(okFunction, showWaitingDialog = true) {
        await baseService.appPost('/logout', null, okFunction, showWaitingDialog);
    },
}
