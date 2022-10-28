import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/comment/list', data, okFunction, showWaitingDialog);
    },
    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/comment/get', data, okFunction, showWaitingDialog);
    },
    // async getPendingDoc(okFunction, showWaitingDialog = true) {
    //     await baseService.appGet('/item-sale/pending-doc', null, okFunction, showWaitingDialog);
    // },
    action(data, okFunction, showWaitingDialog = true){
        baseService.appPost('/comment/action', data, okFunction, showWaitingDialog);
    },
    delete(id, okFunction, showWaitingDialog = true){
        baseService.appDelete('/comment/delete/' + id, null, okFunction, showWaitingDialog);
    },
}


