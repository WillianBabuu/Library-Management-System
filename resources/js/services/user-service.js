import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/user/list', data, okFunction, showWaitingDialog);
    },
    async searchUser(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/user/company/list', data, okFunction, true);
    },
    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/user/get', data, okFunction, showWaitingDialog);
    },
    action(data, okFunction, showWaitingDialog = true){
        baseService.appPost('/user/action', data, okFunction, showWaitingDialog);
    },
    delete(id, okFunction, showWaitingDialog = true){
        baseService.appDelete('/user/delete/' + id, null, okFunction, showWaitingDialog);
    },
}
