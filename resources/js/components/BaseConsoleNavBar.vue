<template>
    <div class="flex justify-between py-3 px-6 bg-gradient-to-r from-indigo-600 to-indigo-400 border-b">
        <div clas="flex items-center flex-1">
            <button type="button" value="Open sidebar"
                    class="md:hidden mr-3 flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-md hover:text-gray-600 hover:ring-2 hover:ring-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-600"
                    @click="sidebarOpen">
                <base-heroicon computed-icon="MenuIcon" :class="'h-6 w-6'"/>
            </button>
        </div>
        <div class="flex md:justify-end">

            <base-drop-down
                :list-of-item="[
                { icon: 'StarIcon', description : 'Books List', okFunction: ()=>{ goToNewItem(); }, disabled: false, },
                ]">
                <base-btn-icon-only btn-icon="PlusIcon" class="bg-white text-black"/>
            </base-drop-down>

            <form action="#" class="ml-2">
                <div class="relative flex items-center text-gray-400 focus-within:text-gray-600">
                    <base-heroicon computed-icon="SearchIcon" :class="'absolute ml-3 pointer-events-none'"/>
                    <input type="text" name="nav_bar_search" placeholder="Search" autocomplete="off" aria-label="Search"
                           class="focus:outline-none pr-3 pl-10 py-2 font-semibold placeholder-gray-500 text-black rounded-md md:border-none ring-1 ring-gray-300 focus:ring-2 focus:ring-gray-500">
                </div>
            </form>

            <base-drop-down :list-of-item="[
                { description : 'Help', okFunction: ()=>{  }, disabled: true, },
                { description : 'Logout', okFunction: ()=>{ logoutAction(); }, disabled: false, },
            ]">
                <img class="w-10 h-10 inline ring-2 ring-offset-2 ring-black rounded-full" :src="userImageLink"/>
            </base-drop-down>
        </div>
    </div>
</template>

<script>
    import { useStore } from 'vuex';
    import BaseBtnIconOnly from "@components/BaseBtnIconOnly";
    import BaseHeroicon from "@components/BaseHeroicon";
    import BaseDropDown from "@components/BaseDropDown";
    import uiService from "@services/ui-service.js";
    import authService from "@services/auth-service.js";

    export default {
        name: 'base-console-nav-bar',
        components: {
            BaseDropDown,
            BaseBtnIconOnly, BaseHeroicon,
        },
        methods: {
            async logoutAction(){
                await uiService.showConfirm("You want to logout?", "Yes, logout!!", async () => {
                    await authService.logout((results)=>{
                        uiService.showSuccess('Success!', results.errorMessage, ()=>{
                            this.$store.commit('currentUser/USER_LOGOUT');
                            this.$router.push({ name: 'login'});
                        });
                    });
                });
            },
            
            goToNewItem() {
                this.$store.commit('sidebar/SET_ACTIVE_MENU_ITEM', 'item-list');
                this.$router.push({ name: 'item-list'});
            },
        },
        /*data(){
            listOfUserDropDownItem : [

            ],
        },*/
        setup() {
            const userImageLink = '/images/USER.png';
            const store = useStore();

            const sidebarOpen = () => {
                store.dispatch('sidebar/sidebarOpenClose', true);
            };

            return {
                sidebarOpen,
                userImageLink,
            }
        },
    }
</script>

<style>
</style>
