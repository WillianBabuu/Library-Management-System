import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/sale/list', data, okFunction, showWaitingDialog);
    },
    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/sale/get', data, okFunction, showWaitingDialog);
    },
    action(data, okFunction, showWaitingDialog = true){
        baseService.appPost('/sale/action', data, okFunction, showWaitingDialog);
    },
    recordSale(data, okFunction, showWaitingDialog = true){
        baseService.appPost('/sale/record', data, okFunction, showWaitingDialog);
    },
    delete(id, okFunction, showWaitingDialog = true){
        baseService.appDelete('/sale/delete/' + id, null, okFunction, showWaitingDialog);
    },
}
