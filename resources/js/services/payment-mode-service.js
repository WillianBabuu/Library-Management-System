import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/payment-type/list', data, okFunction, showWaitingDialog);
    },
    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/payment-type/get', data, okFunction, showWaitingDialog);
    },
    async action(data, okFunction, showWaitingDialog = true){
        baseService.appPost('/payment-type/action', data, okFunction, showWaitingDialog);
    },
    async delete(id, okFunction, showWaitingDialog = true){
        baseService.appDelete('/payment-type/delete/' + id, null, okFunction, showWaitingDialog);
    },
}
