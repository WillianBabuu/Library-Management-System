import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/Tax/list', data, okFunction, showWaitingDialog);
    },
    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/Tax/get', data, okFunction, showWaitingDialog);
    },
    async action(data, okFunction, showWaitingDialog = true){
        baseService.appPost('/Tax/action', data, okFunction, showWaitingDialog);
    },
    async delete(id, okFunction, showWaitingDialog = true){
        baseService.appDelete('/Tax/delete/' + id, null, okFunction, showWaitingDialog);
    },
}
