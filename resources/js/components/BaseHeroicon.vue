<template>
    <component :is="computedIcon" class="w-5 h-5" aria-hidden="true"/>
</template>

<script>
    import { defineAsyncComponent } from "vue";

    export default {
        name: 'base-heroicon',
        props: {
            computedIcon: String,
        },
        components: {},
        computed: {
            computedIcon(){
                return defineAsyncComponent(() => import(`@heroicons/vue/outline/${this.computedIcon}.js`))
            }
        },
    }
</script>

<style>
</style>
