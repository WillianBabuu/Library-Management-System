<template>
    <div class="flex min-h-screen h-full overflow-hidden bg-gray-100">
        <base-console-side-bar></base-console-side-bar>
        <div class="flex-1">
            <base-console-nav-bar></base-console-nav-bar>
            <div class="flex flex-col p-4 md:p-8">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    import BaseConsoleNavBar from "@components/BaseConsoleNavBar";
    import BaseConsoleSideBar from "@components/BaseConsoleSideBar";
    export default {
        name: 'console-layout',
        components: {
            BaseConsoleNavBar, BaseConsoleSideBar,
        },
    }
</script>

<style>
</style>
