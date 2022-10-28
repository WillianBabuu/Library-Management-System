<template>
    <button class="inline-flex whitespace-nowrap items-center border font-medium
            focus:outline-none focus:ring-2 focus:ring-offset-2
            px-4 py-2 text-sm leading-5 rounded-md border-transparent shadow-sm text-white"
            :class="'bg-' + btnColor + '-600 hover:bg-' + btnColor + '-700 focus:ring-' + btnColor + '-500'">
        <component :is="btnIconComp" class="h-5 w-5 -ml-1 mr-2"/> {{ btnLabel }}
    </button>
</template>

<script>
    import { defineAsyncComponent } from "vue";

    export default {
        name: 'base-btn',
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
