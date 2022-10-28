<template>
    <Switch
        v-model="enabled"
        :class="enabled ? 'bg-indigo-600' : 'bg-gray-400'"
        class="relative inline-flex flex-shrink-0 h-[28px] w-[65px] border-2 border-transparent rounded-full
        cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus-visible:ring-2
        focus-visible:ring-white focus-visible:ring-opacity-75">
        <!--<span class="sr-only">Use setting</span>-->
        <span
            aria-hidden="true"
            :class="enabled ? 'translate-x-9' : 'translate-x-0'"
            class="pointer-events-none inline-block h-[24px] w-[24px] rounded-full bg-white shadow-lg
            transform ring-0 transition ease-in-out duration-200"
        />
    </Switch>
</template>

<script>
    import { ref } from 'vue'
    import { Switch } from '@headlessui/vue'

    export default {
        name: 'base-switch',
        components: {
            Switch,
        },
        data(){
            return {
                enabled: ref(false),
            }
        },
    }
</script>

<style>
</style>
