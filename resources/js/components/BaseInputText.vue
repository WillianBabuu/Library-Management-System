<template>
    <input
        :value="inputValue"
        type="text" :id="id"
        class="box-border text-black placeholder-gray-400 text-sm rounded-lg bg-white border border-gray-200
        border-solid rounded outline-none focus:ring-indigo-400 focus:border-indigo-400 block w-full p-2.5"
        @input="updateInputValue($event.target.value)"
        :placeholder="placeholder" />
</template>

<script>
    export default {
        name: 'base-input-text',
        props: {
            inputValue: { type: Object },
            placeholder: { type: String },
            id: { type: String },
        },
        methods: {
            updateInputValue(inputValue){
                this.$emit('update:inputValue', inputValue);
            }
        },
        components: {},
    }
</script>

<style>
</style>
