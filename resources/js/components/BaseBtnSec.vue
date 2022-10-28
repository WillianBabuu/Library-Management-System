<template>
    <button class="inline-flex whitespace-nowrap items-center border font-medium focus:outline-none
        focus:ring-2 focus:ring-offset-2 px-3 py-2 text-sm leading-4 rounded-md border-transparent
         font-normal transition ease-in-out duration-150"
            :class="'border-solid border-' + btnColor + '-500 text-' + btnColor + '-500 hover:bg-' + btnColor + '-200 shadow-inner focus:ring-' + btnColor + '-500'">
        <component :is="btnIconComp" class="h-5 w-5 -ml-1 mr-2 h-5 w-5"/> {{ btnLabel }}
    </button>
</template>

<script>
    import { defineAsyncComponent } from "vue";

    export default {
        name: 'base-btn-sec',
        props: {
            btnColor: String, btnLabel: String, btnIcon: String,
        },
        components: {},
        computed: {
            btnIconComp(){
                return defineAsyncComponent(() => import(`@heroicons/vue/outline/${this.btnIcon}.js`))
            }
        }
    }
</script>

<style>
</style>
