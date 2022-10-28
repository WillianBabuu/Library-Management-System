import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/purchase/list', data, okFunction, showWaitingDialog);
    },
    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/purchase/get', data, okFunction, showWaitingDialog);
    },
    async getPendingDoc(okFunction, showWaitingDialog = true) {
        await baseService.appGet('/purchase/pending-doc', null, okFunction, showWaitingDialog);
    },
    action(data, okFunction, showWaitingDialog = true){
        baseService.appPost('/purchase/action', data, okFunction, showWaitingDialog);
    },
    delete(id, okFunction, showWaitingDialog = true){
        baseService.appDelete('/purchase/delete/' + id, null, okFunction, showWaitingDialog);
    },
}
