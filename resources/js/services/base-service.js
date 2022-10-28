import axios from "axios";
import store from "../store";
import Swal from "sweetalert2";

let axiosClient = axios.create({
    baseURL: '/api'
});

axiosClient.interceptors.request.use( config => {
    const token = store.state.currentUser.user.token;
    if(token) { config.headers.Authorization = `Bearer ${token}`; }
    config.headers.ContentType = 'application/json';
    config.headers.Accept = 'application/json';
    const company_id = store.state.currentUser.user.company_id;
    if(company_id) {
        if(config.params) { config.params.current_company_id = company_id; }
        else { config.params = { current_company_id:  company_id }; }
    }
    return config;
});

const appGet = async (endpoint, data, okFunction, showWaitingDialog = false, canDebug = false) => {
    if (showWaitingDialog) { store.commit('SHOW_WAITING_LOADER', true); }
    await axiosClient.get(endpoint, { params: data }).then(({data})=>{
        thenFn(data, okFunction, showWaitingDialog, canDebug);
    }).catch((err)=>{
        catchErr(err.response, showWaitingDialog, canDebug);
    });
};

const appGetFile = async (endpoint, data, okFunction, showWaitingDialog = false, canDebug = false) => {
    if (showWaitingDialog) { store.commit('SHOW_WAITING_LOADER', true); }
    await axiosClient.get(endpoint, { params: data, responseType: 'blob' }).then(({data})=>{
        thenFnFile(data, okFunction, showWaitingDialog, canDebug);
    }).catch((err)=>{
        catchErr(err.response, showWaitingDialog, canDebug);
    });
};

const appPost = async (endpoint, data, okFunction, showWaitingDialog = false, canDebug = false) => {
    if (showWaitingDialog) { store.commit('SHOW_WAITING_LOADER', true); }
    await axiosClient.post(endpoint, data).then(({data})=>{
        thenFn(data, okFunction, showWaitingDialog, canDebug);
    }).catch((err)=>{
        catchErr(err.response, showWaitingDialog, canDebug);
    });
};

const appDelete = async (endpoint, data, okFunction, showWaitingDialog = false, canDebug = false) => {
    if (showWaitingDialog) { store.commit('SHOW_WAITING_LOADER', true); }
    await axiosClient.delete(endpoint, data).then(({data})=>{
        thenFn(data, okFunction, showWaitingDialog, canDebug);
    }).catch((err)=>{
        catchErr(err.response, showWaitingDialog, canDebug);
    });
};

const thenFn = (data, okFunction, showWaitingDialog = false, canDebug = false) => {
    if(canDebug) { console.log(data); }
    if (showWaitingDialog) { store.commit('SHOW_WAITING_LOADER', false); }
    if(data.status === 'OK') {
        okFunction(data);
    } else {
        Swal.fire({
            icon: 'error',
            html: data.errorMessage,
            allowOutsideClick: false,
        });
    }
};

const thenFnFile = (data, okFunction, showWaitingDialog = false, canDebug = false) => {
    if(canDebug) { console.log(data); }
    if (showWaitingDialog) { store.commit('SHOW_WAITING_LOADER', false); }
    if(data.status === 'OK') {
        okFunction(data);
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", this.document.name);
        document.body.appendChild(link);
        link.click();
        link.remove();
    } else {
        Swal.fire({
            icon: 'error',
            html: data.errorMessage,
            allowOutsideClick: false,
        });
    }
};

const catchErr = (err, showWaitingDialog = false, canDebug = false) => {
    if(canDebug) { console.log(err); }
    if (showWaitingDialog) { store.commit('SHOW_WAITING_LOADER', false); }
    let errMsg = '';
    if(err) {
        if(err.status) { errMsg += '<br/><b>STATUS : </b>'+ err.status; }
        if(err.statusText) { errMsg += '<br/><b>STATUS TEXT: </b>'+ err.statusText; }
        if(err.data) {
            if(err.data.message) { errMsg += '<br/><b>MESSAGE : </b>'+ err.data.message; }
            if(err.data.errors) {
                errMsg += '<br/><b>ERROR(s) : </b>';
                const listOfErrors = Object.values(err.data.errors);
                listOfErrors.forEach((error) => {
                    errMsg += error + ', ';
                });
            }
        }
    }

    Swal.fire({
        icon: 'error',
        title: 'Something went wrong!',
        html: errMsg,
        allowOutsideClick: false,
    });
};

export default {
    appGet, appGetFile, appPost, appDelete,
};
