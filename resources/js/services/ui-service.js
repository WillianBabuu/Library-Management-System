import Swal from "sweetalert2";

const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'm-1 inline-flex whitespace-nowrap items-center border font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 px-4 py-2 text-sm leading-5 rounded-md border-transparent shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500',
        cancelButton: 'm-1 inline-flex whitespace-nowrap items-center border font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 px-4 py-2 text-sm leading-5 rounded-md border-transparent border-solid font-normal transition ease-in-out duration-150 shadow-inner border-indigo-500 text-indigo-500 hover:bg-indigo-200 focus:ring-indigo-500'
    },
    buttonsStyling: false,
    allowOutsideClick: false,
});

const confirmDelete =  (okFunction) => {
    /*swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            okFunction();
        }
    });*/
    showConfirm("You won't be able to revert this!", "Yes, delete it!!", okFunction);
};

const confirmReturn =  (okFunction) => {
    showConfirm("You won't be able to revert this!", "Yes, add to return list!!", okFunction);
};

const showConfirm =  (message, confirmButtonText, okFunction) => {
    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        cancelButtonText: 'No, cancel!',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            okFunction();
        }
    });
};

const showSuccess = (title, message, okFunction) => {
    swalWithBootstrapButtons.fire(title, message, 'success').then(()=>{
        okFunction();
    });
};

export default {
    confirmDelete, showSuccess, showConfirm, confirmReturn
};
