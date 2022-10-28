<template>
    <console-layout>
        <div class="flex flex-wrap justify-between">
            <base-console-breadcrumb showBreadcrumb="true" title='User List' linkTitle='User List'/>
            <base-btn-container>
            </base-btn-container>
        </div>
        <div>
            <div class="flex flex-col pt-5">
                <base-table-wrap>
                    <base-table>
                        <thead class="bg-gray-50">
                        <tr>
                            <base-table-header>Name</base-table-header>
                            <base-table-header>Email</base-table-header>
                            <base-table-header-end>Action</base-table-header-end>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, indexItem) in listOfUser" :key="indexItem" :class="(indexItem % 2 == 0) ? 'bg-white':'bg-gray-50'">
                            <base-table-data>{{ item.name }}</base-table-data>
                            <base-table-data>{{ item.email }}</base-table-data>
                            <base-table-data :class="'text-right'">

                                <base-drop-down :list-of-item="[
                                        { icon : 'TrashIcon',  description : 'Delete', okFunction: ()=>{ deleteUser(item.id); }, disabled: false, },
                                    ]" v-if="currentUser.is_admin == 1 && currentUser.id != item.id">
                                    <base-heroicon computed-icon="DotsHorizontalIcon"/>
                                </base-drop-down>

                            </base-table-data>

                        </tr>
                        </tbody>
                    </base-table>
                    <base-table-no-results-found v-if="!listOfUser.length"/>
                </base-table-wrap>
            </div>
        </div>
    </console-layout>
</template>

<script>
    import ConsoleLayout from "@layout/ConsoleLayout";
    import BaseConsoleBreadcrumb from "@components/breadcrumb/BaseConsoleBreadcrumb";
    import BaseBtnContainer from "@components/BaseBtnContainer";
    import BaseBtn from "@components/BaseBtn";
    import BaseTableNoResultsFound from "@components/BaseTableNoResultsFound";
    import BaseTable from "@components/table/BaseTable";
    import BaseTableWrap from "@components/table/BaseTableWrap";
    import BaseTableHeader from "@components/table/BaseTableHeader";
    import BaseTableData from "@components/table/BaseTableData";
    import BaseTableHeaderEnd from "@components/table/BaseTableHeaderEnd";
    import BaseHeroicon from "@components/BaseHeroicon";
    import BaseDropDown from "@components/BaseDropDown";
    import uiService from "@services/ui-service.js";
    import userService from "@services/user-service.js";

    export default {
        name: 'user-list',
        components: {
            BaseHeroicon, BaseDropDown,
            BaseTableHeaderEnd, BaseTableData, BaseTableHeader,
            BaseTableWrap, BaseTable,
            BaseBtn,
            BaseBtnContainer,
            BaseConsoleBreadcrumb,
            BaseTableNoResultsFound,
            ConsoleLayout,
        },
        data() {
            return {
                listOfUser: {
                    stores:[]
                },
                currentUser: []
            }
        },
        async created() {
            // console.log('About to get User List');
            await this.searchUsers();
            await this.getUser();
        },
        methods: {
            async searchUsers() {
                userService.search({}, (result)=>{
                    this.listOfUser = result.returnData.list_of_users;
                });
            },
            async getUser(){
                await userService.get({ }, (result)=>{
                    this.currentUser = result.returnData.item;
                });
            },
            async goToAddUser(){
                this.$router.push({ name: 'user-form' });
            },
            async deleteUser(id){
                uiService.confirmDelete(()=>{
                    userService.delete(id, (results)=>{
                        uiService.showSuccess('Deleted!', results.errorMessage);
                    });
                });
            },
        },
    }
</script>

<style>
</style>
