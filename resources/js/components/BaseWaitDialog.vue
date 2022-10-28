<template>
    <base-dialog ref="baseDialogForWaitDialog">
        <rotate-square2 size="70px"/>
    </base-dialog>
</template>

<script>
    import { RotateSquare2 } from 'vue-loading-spinner';
    import BaseDialog from "./BaseDialog";

    export default {
        name: 'base-wait-dialog',
        components: {
            BaseDialog,
            RotateSquare2,
        },
        mounted() { },
        setup() {
            function nowShow(){
                this.$refs.baseDialogForWaitDialog.openModal();
            }
            function nowHide(){
                this.$refs.baseDialogForWaitDialog.closeModal();
            }
            return {
                nowShow, nowHide,
            }
        },
    }
</script>

<style>
    .spinner::after {
        background: #4f46e5 !important;
    }
</style>
