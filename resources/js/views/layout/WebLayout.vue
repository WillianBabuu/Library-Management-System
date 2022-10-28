<template>
    <base-web-nav-bar></base-web-nav-bar>
    <slot></slot>
</template>

<script>
    import BaseWebNavBar from "@components/BaseWebNavBar.vue";

    export default {
        name: 'web-layout',
        components: {
            BaseWebNavBar,
        },
    }
</script>

<style>
</style>
