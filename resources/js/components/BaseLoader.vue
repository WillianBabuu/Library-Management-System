<template>
    <div class="base-loader-overlay">
        <div class="loading-box rounded-md">
            <component :is="optionWaitingLoader"/>
            <h3>{{ text }}</h3>
        </div>
    </div>
</template>

<script>
    import BaseLoaderOption1 from "@components/loader/BaseLoaderOption1";
    import BaseLoaderOption2 from "@components/loader/BaseLoaderOption2";
    import BaseLoaderOption3 from "@components/loader/BaseLoaderOption3";
    import BaseLoaderOption4 from "@components/loader/BaseLoaderOption4";
    import BaseLoaderOption5 from "@components/loader/BaseLoaderOption5";
    import BaseLoaderOption6 from "@components/loader/BaseLoaderOption6";
    import BaseLoaderOption7 from "@components/loader/BaseLoaderOption7";
    import BaseLoaderOption8 from "@components/loader/BaseLoaderOption8";
    import BaseLoaderOption9 from "@components/loader/BaseLoaderOption9";
    import BaseLoaderOption10 from "@components/loader/BaseLoaderOption10";
    import BaseLoaderOption11 from "@components/loader/BaseLoaderOption11";
    import BaseLoaderOption12 from "@components/loader/BaseLoaderOption12";
    import { mapState } from "vuex";

    export default {
        name: 'base-loader',
        components: {
            BaseLoaderOption1, BaseLoaderOption2, BaseLoaderOption3, BaseLoaderOption4,
            BaseLoaderOption5, BaseLoaderOption6, BaseLoaderOption7, BaseLoaderOption8,
            BaseLoaderOption9, BaseLoaderOption10, BaseLoaderOption11, BaseLoaderOption12,
        },
        props: {
            text: {
                required: false,
                default : 'Loading .....'
            }
        },
        mounted() {
            console.log("TESTING");
        },
        computed: {
            ...mapState({
                optionWaitingLoader: state => state.optionWaitingLoader,
            }),
        },
    }
</script>

<style>
    .loading-box {
        position: fixed;
        top: 30%;
        width: 25%;
        margin: auto;
        background: #fff;
        box-shadow: 0px 0px 9px -2px #000;
        z-index: 999;
        left: 0px;
        right: 0px;
        text-align: center;
        padding: 20px;
    }
    .base-loader-overlay {
        background-color: rgba(0, 0, 0, .5);
        position: fixed;
        top: 0; bottom: 0; left: 0; right: 0;
        z-index: 900;
    }
</style>
