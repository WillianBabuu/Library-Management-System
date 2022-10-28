<template>
    <div class="hidden mt-1 xl:block min-w-[240px]">
        <div class="list-none">

            <router-link
                v-for="(menuItem, index) in listOfSettingMenuItem"
                :to="{ name: menuItem.page }" :key="index"
                class="py-3 cursor-pointer pb-2 pr-0 text-sm font-medium leading-5  flex items-center text-gray-500 py-3"
                :class="this.isActiveSettingSideBarMenuItem(menuItem.page) ? 'text-indigo-500': ''"
                v-on:click="this.setActiveSettingSideBarMenuItem(menuItem.page)">
                <span class="mr-3">
                    <base-heroicon :computed-icon="menuItem.icon"/>
                </span>
                <span>{{ menuItem.label }}</span>
            </router-link>

        </div>
    </div>
</template>

<script>
    import BaseHeroicon from "@components/BaseHeroicon";

    export default {
        name: 'base-console-settings-side-bar',
        components: {
            BaseHeroicon,
        },
        data() {
            return {
                activeSettingSideBarMenuItem: this.$store.state.sidebar.activeSettingMenuItem,
                listOfSettingMenuItem: this.$store.state.sidebar.listOfSettingMenuItem,
            }
        },
        methods: {
            isActiveSettingSideBarMenuItem: function (menuItem) {
                return this.activeSettingSideBarMenuItem === menuItem;
            },
            setActiveSettingSideBarMenuItem: function (menuItem) {
                this.$store.commit('sidebar/SET_ACTIVE_SETTING_MENU_ITEM', menuItem);
            }
        },
    }
</script>

<style>
</style>
