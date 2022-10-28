import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/payment/list', data, okFunction, showWaitingDialog);
    },
    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/payment/get', data, okFunction, showWaitingDialog);
    },
    async action(data, okFunction, showWaitingDialog = true){
        baseService.appPost('/payment/action', data, okFunction, showWaitingDialog);
    },
    async delete(id, okFunction, showWaitingDialog = true){
        baseService.appDelete('/payment/delete/' + id, null, okFunction, showWaitingDialog);
    },
}
