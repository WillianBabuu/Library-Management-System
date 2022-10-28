import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/receiving/list', data, okFunction, showWaitingDialog);
    },
    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/receiving/get', data, okFunction, showWaitingDialog);
    },
    async updatePrices(data, okFunction, showWaitingDialog = true) {
        await baseService.appPost('/receiving/prices-update', data, okFunction, showWaitingDialog);
    },
    async updatePricesLpo(data,okFunction, showWaitingDialog = true) {
        await baseService.appPost('/receiving/prices-update-lpo', data, okFunction, showWaitingDialog);
    },
    action(data, okFunction, showWaitingDialog = true){
        baseService.appPost('/receiving/action', data, okFunction, showWaitingDialog);
    },
    delete(id, okFunction, showWaitingDialog = true){
        baseService.appDelete('/receiving/delete/' + id, null, okFunction, showWaitingDialog);
    },
}
