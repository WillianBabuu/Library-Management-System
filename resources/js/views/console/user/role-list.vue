<template>
    <settings-layout>
        <div class="flex flex-wrap justify-between lg:flex-nowrap mb-5">
            <div>
                <h6 class="font-medium text-lg text-left">User Roles</h6>
                <p class="mt-2 text-sm leading-snug text-left text-gray-500 max-w-[680px]">
                    List of user roles
                </p>
            </div>
            <div class="mt-4 lg:mt-0 lg:ml-2">
                <base-btn-outline @click="this.$refs.slideOverDialogUserRole.setIsOpen(true)"
                                  btn-icon="PlusIcon" btn-label="Add User Role" btn-color="indigo"/>
            </div>
        </div>

        <div>
            <div class="flex flex-col pt-5">
                <base-table-wrap>
                    <base-table>
                        <thead class="bg-gray-50">
                        <tr>
                            <base-table-header>Role Name</base-table-header>
                            <base-table-header>Description</base-table-header>
                            <base-table-header-end>Action</base-table-header-end>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, indexItem) in listOfUserRole" :key="indexItem" :class="(indexItem % 2 == 0) ? 'bg-white':'bg-gray-50'">
                                <base-table-data>{{ item.name }}</base-table-data>
                                <base-table-data>{{ item.description }}</base-table-data>

                                <base-table-data :class="'text-right'">

                                    <base-drop-down :list-of-item="[
                                        { icon : 'PencilIcon',  description : 'Edit', okFunction: ()=>{ goToEditSystemSetting(item.id); }, disabled: false, },
                                        { icon : 'TrashIcon',  description : 'Delete', okFunction: ()=>{ deleteSystemSetting(item.id); }, disabled: false, },
                                    ]">
                                        <base-heroicon computed-icon="DotsHorizontalIcon"/>
                                    </base-drop-down>

                                </base-table-data>

                            </tr>
                        </tbody>
                    </base-table>
                    <base-table-no-results-found v-if="!listOfUserRole.length"/>
                </base-table-wrap>
            </div>
        </div>
    </settings-layout>
    <slide-over-dialog-user-role ref="slideOverDialogUserRole" @refreshUserRole="searchUserRole"/>
</template>

<script>
    import ConsoleLayout from "@layout/ConsoleLayout";
    import SettingsLayout from "@layout/SettingsLayout";
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
    import BaseBtnOutline from "@components/BaseBtnOutline";
    import SlideOverDialogUserRole from "@views/console/slide-over-dialog/SlideOverDialogUserRole";
    import uiService from "@services/ui-service.js";
    import userRoleService from "@services/user-role-service.js";


    export default {
        name: 'user-role-list',
        components: {
            SlideOverDialogUserRole,
            BaseBtnOutline,
            SettingsLayout,
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
                listOfUserRole: [
                ],
            }
        },
        async created() {
            console.log('About to get User Role List');
            await this.searchUserRole();
        },
        methods: {
            async searchUserRole() {
                userRoleService.search({q:''}, (result)=>{
                    this.listOfUserRole = result.returnData.list_of_items;
                });
            },
            async goToEditUserRole(id){
                this.$router.push({ name: 'user-role-form', params: { id:id } });
            },
            async deleteUserRole(id){
                uiService.confirmDelete(()=>{
                    userRoleService.delete(id, (results)=>{
                        uiService.showSuccess('Deleted!', results.errorMessage);
                    });
                });
            }
        },
    }
</script>

<style>
</style>
