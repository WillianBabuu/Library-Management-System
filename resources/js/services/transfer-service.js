import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/transfer/list', data, okFunction, showWaitingDialog);
    },
    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/transfer/get', data, okFunction, showWaitingDialog);
    },
    async transferNow(data, okFunction, showWaitingDialog = true) {
        await baseService.appPost('/transfer/transfer-now', data, okFunction, showWaitingDialog);
    },
    action(data, okFunction, showWaitingDialog = true){
        baseService.appPost('/transfer/action', data, okFunction, showWaitingDialog);
    },
    delete(id, okFunction, showWaitingDialog = true){
        baseService.appDelete('/transfer/delete/' + id, null, okFunction, showWaitingDialog);
    },
}
