<template>
    <div class="text-center text-gray-500 pb-2 flex h-[160px] justify-center items-center flex-col">
        <ExclamationCircleIcon class="h-5 w-5 w-6 h-6 text-gray-400"/>
        <span class="block mt-1">No Results Found</span>
    </div>
</template>

<script>
    import { ExclamationCircleIcon } from "@heroicons/vue/outline";

    export default {
        name: 'base-table-no-results-found',
        components: {
            ExclamationCircleIcon,
        },
    }
</script>

<style>
</style>
