<template>
    <div class="-my-2 sm:-mx-6 lg:-mx-8 pb-4 lg:pb-0">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="relative bg-white border-b border-gray-200 shadow sm:rounded-lg">
                <slot/>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'base-table-wrap',
        components: {},
    }
</script>

<style>
</style>
