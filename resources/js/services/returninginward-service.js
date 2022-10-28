import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/returninginward/list', data, okFunction, showWaitingDialog);
    },
    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/returning/get', data, okFunction, showWaitingDialog);
    },
    async returninginwardItems(data, okFunction, showWaitingDialog = true) {
        await baseService.appPost('/returninginward/item-returning', data, okFunction, showWaitingDialog);
    },
    action(data, okFunction, showWaitingDialog = true){
        baseService.appPost('/returninginward/action', data, okFunction, showWaitingDialog);
    },
    delete(id, okFunction, showWaitingDialog = true){
        baseService.appDelete('/returninginward/delete/' + id, null, okFunction, showWaitingDialog);
    },
}
