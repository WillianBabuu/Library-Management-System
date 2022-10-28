<template>
    <Menu as="div" class="relative ml-2">
        <MenuButton class="focus:outline-none">
            <slot/>
        </MenuButton>
        <transition enter-active-class="transition transform duration-100 ease-out"
                    enter-from-class="opacity-0 scale-90"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="transition transform duration-100 ease-in"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-90">
            <MenuItems class="origin-top mt-2 focus:outline-none absolute right-0 bg-white divide-y divide-gray-100 rounded-md shadow-lg border w-48 z-40 text-left">
                <div class="px-1 py-1">
                    <MenuItem
                        v-slot="{active, disabled}" v-for="(item, indexItem) in listOfItem"
                        :key="indexItem" :value="item" :disabled="item.disabled">
                        <a href="#" :class="{ 'bg-indigo-100' : active, 'opacity-40' : disabled }"
                           @click="itemAction(item.okFunction)"
                           class="block py-2 px-4 text-sm text-gray-700">
                            <base-heroicon :class="'inline'" :computed-icon="item.icon"/>
                            {{ item.description }}
                        </a>
                    </MenuItem>
                </div>
                <div class="px-1 py-1" v-if="listOfItemTwo">
                    <MenuItem
                        v-slot="{active, disabled}" v-for="(item, indexItem) in listOfItemTwo"
                        :key="indexItem" :value="item" :disabled="item.disabled">
                        <a href="#" :class="{ 'bg-indigo-100' : active, 'opacity-40' : disabled }"
                           @click="itemAction(item.okFunction)"
                           class="block py-2 px-4 text-sm text-gray-700">
                            <base-heroicon :class="'inline'" :computed-icon="item.icon"/>
                            {{ item.description }}
                        </a>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script>
    export default {
        name: 'base-drop-down',
        props: {
            listOfItem: { type: Array, require: true },
            listOfItemTwo: { type: Array },
        }
    }
</script>

<script setup>
    import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
    import BaseHeroicon from "@components/BaseHeroicon";

    async function itemAction(okFunction) {
        okFunction();
    }
</script>

<style>
</style>
