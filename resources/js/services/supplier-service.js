import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction) {
        await baseService.appGet('/supplier/list', data, okFunction, true);
    },
    /*get(data){
        return baseService.get('/supplier/get', data);
    },*/
    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/supplier/get', data, okFunction, showWaitingDialog);
    },
    action(data, okFunction){
        baseService.appPost('/supplier/action', data, okFunction, true);
    },
    delete(id, okFunction){
        baseService.appDelete('/supplier/delete/' + id, null, okFunction, true);
    },
}
