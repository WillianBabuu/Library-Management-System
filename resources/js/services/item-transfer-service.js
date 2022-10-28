import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/item-transfer/list', data, okFunction, showWaitingDialog);
    },
    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/item-transfer/get', data, okFunction, showWaitingDialog);
    },
    // async getPendingDoc(okFunction, showWaitingDialog = true) {
    //     await baseService.appGet('/item-purchase/pending-doc', null, okFunction, showWaitingDialog);
    // },
    action(data, okFunction, showWaitingDialog = true){
        baseService.appPost('/item-transfer/action', data, okFunction, showWaitingDialog);
    },
    delete(id, okFunction, showWaitingDialog = true){
        baseService.appDelete('/item-transfer/delete/' + id, null, okFunction, showWaitingDialog);
    },
}


