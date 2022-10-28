<template>
    <TransitionRoot :show="sidebarIsOpen">
        <Dialog as="div" @close="sidebarClose" class="fixed inset-0 z-40 md:hidden">
            <TransitionChild as="template"
                             enter="transition ease-in-out duration-200 transform"
                             enter-from="-translate-x-full"
                             enter-to="translate-x-0"
                             leave="transition ease-in-out duration-200 transform"
                             leave-from="translate-x-0"
                             leave-to="-translate-x-full">
                <div class="flex flex-col md:hidden relative z-10 h-full w-72 bg-gray-50 border-r border-gray-200">
                    <button type="button" value="Close Sidebar"
                            class="absolute top-2 right-2 flex items-center justify-center w-10 h-10 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-600"
                            @click="sidebarClose">
                        <XIcon class="h-5 w-5"></XIcon>
                    </button>
                    <div class="pt-8 pb-4 py-3 px-6 bg-gray-50 border-b text-black font-extrabold">
                        <a href="/">
                            <img class="h-10 inline" :src="sidebarLogoImg" v-if="sidebarLogoImg"/> VENDBOX
                        </a>
                    </div>

                    <div class="overflow-y-auto flex-1">
                        <div v-for="(menuHeader, indexHeader) in listOfSideBarMenuItem" :key="indexHeader" class="mb-10">
                            <h3 class="mx-6 mb-2 text-xs text-gray-400 uppercase tracking-widest">{{ menuHeader.header }}</h3>

                            <router-link v-for="(menuItem, index) in menuHeader.menus"
                               :to="{ name: menuItem.page }" :key="index"
                               class="flex items-center px-6 py-2.5 text-gray-500 hover:text-indigo-600 group">
                                <component :is="menuItem.icon" class="h-5 w-5 text-gray-400 mr-2 group-hover:text-indigo-400"/>
                                {{ menuItem.label }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </TransitionChild>
            <TransitionChild as="template"
                             enter="transition-opacity ease-linear duration-200"
                             enter-from="opacity-0"
                             enter-to="opacity-100"
                             leave="transition-opacity ease-linear transform"
                             leave-from="opacity-100"
                             leave-to="opacity-0">
                <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-50"></DialogOverlay>
            </TransitionChild>
        </Dialog>
    </TransitionRoot>
    <div class="flex flex-col hidden md:block w-64 bg-white border-r border-gray-200">
        <div class="py-3 px-6 bg-gray-50 border-b text-black font-bold uppercase tracking-widest">
            <a href="/">
                <img class="h-10 inline" :src="sidebarLogoImg" v-if="sidebarLogoImg"/> VENDBOX
            </a>
        </div>

        <div class="overflow-y-auto flex-1">
            <div v-for="(menuHeader, indexHeader) in listOfSideBarMenuItem" :key="indexHeader" class="mb-2">
                <h3 class="mx-6 mb-2 text-sm text-gray-400 uppercase tracking-widest">{{ menuHeader.header }}</h3>

                <router-link v-for="(menuItem, index) in menuHeader.menus"
                   :to="{ name: menuItem.page }" :key="index"
                   class="flex items-center px-6 py-2.5 text-black text-sm not-italic font-medium
                   hover:bg-gray-100 hover:text-indigo-600 hover:border-indigo-600 group"
                    :class="this.isActiveSideBarMenuItem(menuItem.page) ? 'px-5 bg-gray-100 text-indigo-600 border-l-4 border-indigo-600': ''"
                             v-on:click="this.setActiveSideBarMenuItem(menuItem.page)">
                    <base-heroicon
                        :computed-icon="menuItem.icon"
                        :class="(this.isActiveSideBarMenuItem(menuItem.page) ? 'text-indigo-400':'text-gray-400') + ' mr-2 group-hover:text-indigo-400'"/>
                    {{ menuItem.label }}
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import { TransitionRoot, TransitionChild, Dialog, DialogOverlay } from "@headlessui/vue"
    import { computed, ref } from "vue";
    import { useStore } from 'vuex';
    import BaseHeroicon from "./BaseHeroicon";

    export default {
        name: 'base-console-side-bar',
        components: {
            BaseHeroicon,
            TransitionRoot, TransitionChild, Dialog, DialogOverlay,
        },
        data() {
            return {
                sidebarLogoImg: '/images/logo.png',
                activeSideBarMenuItem: this.$store.state.sidebar.activeMenuItem,
                listOfSideBarMenuItem : [
                    {
                        header: '',
                        menus: [
                            { href: '/', page: 'item-list', label: 'Items', icon: 'StarIcon', },
                        ],
                    },
                ],
            }
        },
        methods: {
            isActiveSideBarMenuItem: function (menuItem) {
                return this.activeSideBarMenuItem === menuItem;
            },
            setActiveSideBarMenuItem: function (menuItem) {
                this.$store.commit('sidebar/SET_ACTIVE_MENU_ITEM', menuItem);
            }
        },
        setup() {
            const store = useStore();
            const sidebarIsOpen = computed( () => store.getters['sidebar/sidebarIsOpen']);
            const sidebarClose = () => {
                store.dispatch('sidebar/sidebarOpenClose', false);
            };

            return {
                sidebarIsOpen, sidebarClose,
            }
        }
    }
</script>

<style>
</style>
