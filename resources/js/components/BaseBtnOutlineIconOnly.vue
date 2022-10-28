<template>
    <button class="inline-flex whitespace-nowrap items-center border font-medium
                focus:outline-none focus:ring-2 focus:ring-offset-2 px-4 py-2 text-sm leading-5
                rounded-md border-transparent  border-solid font-normal
                transition ease-in-out duration-150 shadow-inner "
            :class="'border-' + btnColor + '-500 text-' + btnColor + '-500 hover:bg-' + btnColor + '-200 focus:ring-' + btnColor + '-500'">
        <component :is="btnIconComp" class="h-5 w-5 -ml-1"/>
    </button>
</template>

<script>
    import { defineAsyncComponent } from "vue";

    export default {
        name: 'base-btn-outline-icon-only',
        props: {
            btnColor: String, btnIcon: String,
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
