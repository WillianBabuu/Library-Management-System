<template>
    <div>
        <div class="lds-dual-ring"></div>
    </div>
</template>

<script>
    export default {
        name: 'base-loader-option-1',
        components: {},
    }
</script>

<style>
    .lds-dual-ring {
        display: inline-block;
        width: 80px;
        height: 80px;
    }
    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 64px;
        height: 64px;
        margin: 8px;
        border-radius: 50%;
        border: 6px solid #4f46e5;
        border-color: #4f46e5 transparent #4f46e5 transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }
    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>
