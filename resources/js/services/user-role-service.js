import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction) {
        await baseService.appGet('/role/list', data, okFunction, true);
    },
    /*get(data){
        return baseService.get('/role/get', data);
    },*/
    action(data, okFunction){
        baseService.appPost('/role/action', data, okFunction, true);
    },
    delete(id, okFunction){
        baseService.appDelete('/role/delete/' + id, null, okFunction, true);
    },
}
