import baseService from "@services/base-service.js";

export default {
    async search(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/rfq/list', data, okFunction, showWaitingDialog);
    },

    async get(data, okFunction, showWaitingDialog = true) {
        await baseService.appGet('/rfq/get', data, okFunction, showWaitingDialog);
    },
    async downloadPDF(data, okFunction, showWaitingDialog = true) {
        await baseService.appGetFile('/rfq/download/pdf', data, okFunction, showWaitingDialog);
    },
    action(data, okFunction, showWaitingDialog = true) {
        baseService.appPost('/rfq/action', data, okFunction, showWaitingDialog);
    },
    delete(id, okFunction, showWaitingDialog = true) {
        baseService.appDelete('/rfq/delete/' + id, null, okFunction, showWaitingDialog);
    },
}
