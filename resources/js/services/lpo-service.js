import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/lpo/list', data, okFunction, showWaitingDialog);
    },

    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/lpo/get', data, okFunction, showWaitingDialog);
    },
    async getPendingDoc(okFunction, showWaitingDialog = true) {
        await baseService.appGet('/lpo/pending-doc', null, okFunction, showWaitingDialog);
    },
    action(data, okFunction, showWaitingDialog = true) {
        baseService.appPost('/lpo/action', data, okFunction, showWaitingDialog);
    },
    delete(id, okFunction, showWaitingDialog = true) {
        baseService.appDelete('/lpo/delete/' + id, null, okFunction, showWaitingDialog);
    },
}
