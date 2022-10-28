import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/store/list', data, okFunction, showWaitingDialog);
    },
    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/store/get', data, okFunction, showWaitingDialog);
    },
    action(data, okFunction, showWaitingDialog = true){
        baseService.appPost('/store/action', data, okFunction, showWaitingDialog);
    },
    delete(id, okFunction, showWaitingDialog = true){
        baseService.appDelete('/store/delete/' + id, null, okFunction, showWaitingDialog);
    },
}
