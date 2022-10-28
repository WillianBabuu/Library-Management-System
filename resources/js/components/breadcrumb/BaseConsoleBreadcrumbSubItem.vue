<template>
    <div v-if="showBreadcrumb">
        <h1 class="text-2xl font-bold text-left text-black">{{ title }}</h1>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                        <HomeIcon class="mr-2 w-4 h-4"/>
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <ChevronRightIcon class="w-6 h-6 text-gray-400" />
                        <router-link :to="{ name: linkReturnTitleUri }" class="ml-1 text-sm font-medium text-gray-900 md:ml-2 dark:text-gray-500">{{ linkReturnTitle }}</router-link>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <ChevronRightIcon class="w-6 h-6 text-gray-400" />
                        <span class="ml-1 text-sm font-medium text-gray-400 md:ml-2 dark:text-gray-500">{{ linkTitle }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</template>

<script>
    import { HomeIcon, ChevronRightIcon } from "@heroicons/vue/solid"
    export default {
        name: 'base-console-breadcrumb-sub-item',
        props: {
            showBreadcrumb: Boolean,
            title: String,
            linkTitle: String,
            linkReturnTitle: {
                required: true,
                type: String,
            },
            linkReturnTitleUri: {
                required: true,
                type: String,
            },
        },
        components: {
            HomeIcon, ChevronRightIcon,
        },
    }
</script>

<style>
</style>
