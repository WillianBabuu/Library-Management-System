import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/book/list', data, okFunction, showWaitingDialog);
    },
    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/book/get', data, okFunction, showWaitingDialog);
    },
    async action(data, okFunction, showWaitingDialog = true){
        await baseService.appPost('/book/action', data, okFunction, showWaitingDialog);
    },
    async like(data, okFunction, showWaitingDialog = true){
        await baseService.appPost('/book/like', data, okFunction, showWaitingDialog);
    },
    async favourite(data, okFunction, showWaitingDialog = true){
        await baseService.appPost('/book/favourite', data, okFunction, showWaitingDialog);
    },
    async delete(id, okFunction, showWaitingDialog = true){
       await baseService.appDelete('/book/delete/' + id, null, okFunction, showWaitingDialog);
    },
}
