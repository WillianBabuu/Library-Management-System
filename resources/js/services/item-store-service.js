import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/item-store/list', data, okFunction, showWaitingDialog);
    },
    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/item-store/get', data, okFunction, showWaitingDialog);
    },
    // async getPendingDoc(okFunction, showWaitingDialog = true) {
    //     await baseService.appGet('/item-sale/pending-doc', null, okFunction, showWaitingDialog);
    // },
    action(data, okFunction, showWaitingDialog = true){
        baseService.appPost('/item-store/action', data, okFunction, showWaitingDialog);
    },
    delete(id, okFunction, showWaitingDialog = true){
        baseService.appDelete('/item-store/delete/' + id, null, okFunction, showWaitingDialog);
    },
}


