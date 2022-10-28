<template>
    <console-layout>
        <div class="flex flex-wrap justify-between">
            <base-console-breadcrumb-sub-item showBreadcrumb="true" link-return-title='Users' link-return-title-uri='user-list' title='User Form' linkTitle='User Form'/>
        </div>

        <div>
            <div class="flex flex-col pt-5">

                <form @submit.prevent="saveUser">
                    <div class="bg-white rounded-lg shadow w-full">
                        <div class="px-4 py-5 sm:px-8 sm:py-8">
                            <div class="grid gap-y-6 gap-x-4 grid-cols-1">
                                <div class="grid xl:grid-cols-2 xl:gap-6">
                                    <div class="relative z-0 w-full group">
                                        <label for="name" class="block mb-2 text-sm font-medium text-gray-800">Name</label>
                                        <input type="text" id="name" v-model="form.name" class="box-border text-black placeholder-gray-400
                                text-sm rounded-lg bg-white border border-gray-200 border-solid
                                rounded outline-none focus:ring-indigo-400 focus:border-indigo-400 block w-full p-2.5"
                                               placeholder="name" />
                                    </div>
                                    <div class="relative z-0 w-full group">
                                        <label for="email" class="block mb-2 text-sm font-medium text-gray-800">Email</label>
                                        <input type="email" id="email" v-model="form.email"  class="box-border text-black placeholder-gray-400
                                text-sm rounded-lg bg-white border border-gray-200 border-solid
                                rounded outline-none focus:ring-indigo-400 focus:border-indigo-400 block w-full p-2.5"
                                               placeholder="Email" />
                                    </div>
                                    <div class="relative z-0 w-full group">
                                        <label for="password" class="block mb-2 text-sm font-medium text-gray-800">Password</label>
                                        <input id="password" v-model="form.password" type="password"
                                            class="appearance-none rounded-none relative block w-full px-3 py-2 border
                                    placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500
                                    focus:border-indigo-500 focus:z-10 sm:text-sm"
                                        placeholder="Password" />
                                    </div>
                                    <div class="relative z-0 w-full group">
                                        <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-800">Password</label>
                                        <input id="password_confirmation" v-model="form.password_confirmation" type="password"
                                            class="appearance-none rounded-none relative block w-full px-3 py-2 border
                                    placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500
                                    focus:border-indigo-500 focus:z-10 sm:text-sm"
                                        placeholder="Confirm Password" />
                                    </div>

                                    <div class="relative z-0 w-full group">
                                        <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-800">Store</label>
                                            <select id="store_id" v-model="form.store_id" 
                                                class="box-border text-black placeholder-gray-400 text-sm rounded-lg bg-white border border-gray-200
                                                border-solid rounded outline-none focus:ring-indigo-400 focus:border-indigo-400 block w-full p-2.5" >
                                            <option value="">-- CHOOSE STORE TO BIND USER --</option>
                                            <option :value="store.id" v-for="store in listOfStores" :key="store">{{ store.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <base-btn btn-label="Save User" btn-icon="SaveIcon" btn-color="indigo"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </console-layout>
</template>

<script>
    import ConsoleLayout from "@layout/ConsoleLayout";
    import BaseConsoleBreadcrumbSubItem from "@components/breadcrumb/BaseConsoleBreadcrumbSubItem";
    import BaseBtn from "@components/BaseBtn";
    import uiService from "@services/ui-service.js";
    import userService from "@services/user-service.js";
    import BaseBtnIconOnly from "@components/BaseBtnIconOnly";
    import storeService from "@services/store-service.js";
    export default {
        name: 'user-form',
        components: {
            BaseBtnIconOnly,
            BaseConsoleBreadcrumbSubItem,
            BaseBtn,
            ConsoleLayout,
        },
        data() {
            return {
                form: {
                    id: '', form_method: '', name: '', email: '', password: '', password_confirmation: '',store_id:''
                },
                listOfStores:[],
            };
        },
        async created() {
            await this.searchStore();
        },
        methods: {
            async saveUser() {
                userService.action(this.form, (results)=>{
                    uiService.showSuccess('Success', results.returnData.errorMessage, ()=>{
                        this.$router.push({ name: 'user-list'});
                    });
                });
            },
            async searchStore() {
                storeService.search({q:''}, (result)=>{
                    this.listOfStores = result.returnData.list_of_items;
                });
            },
        },
    }
</script>

<style>
</style>
