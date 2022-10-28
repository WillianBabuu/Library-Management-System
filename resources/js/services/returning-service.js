import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/returning/list', data, okFunction, showWaitingDialog);
    },
    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/returning/get', data, okFunction, showWaitingDialog);
    },
    async returningItems(data, okFunction, showWaitingDialog = true) {
        await baseService.appPost('/returning/item-returning', data, okFunction, showWaitingDialog);
    },
    action(data, okFunction, showWaitingDialog = true){
        baseService.appPost('/returning/action', data, okFunction, showWaitingDialog);
    },
    delete(id, okFunction, showWaitingDialog = true){
        baseService.appDelete('/returning/delete/' + id, null, okFunction, showWaitingDialog);
    },
}
