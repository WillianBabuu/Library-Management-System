<template>
    <router-view/>
    <base-loader v-if="showWaitingLoader"/>
</template>

<script>
    import BaseLoader from "@components/BaseLoader";
    import { mapState } from "vuex";

    export default {
        components: {
            BaseLoader
        },
        computed: {
            ...mapState({
                showWaitingLoader: state => state.showWaitingLoader,
            }),
        },
    }
</script>

<style>
</style>
