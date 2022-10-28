<template>
  <div class="flex flex-wrap justify-between lg:flex-nowrap mb-5">
            <div>
                <h6 class="font-medium text-lg text-left">Attribute Groups</h6>
                <p class="mt-2 text-sm leading-snug text-left text-gray-500 max-w-[680px]">
                    List of Attributes Groups
                </p>
            </div>
            <div class="mt-4 lg:mt-0 lg:ml-2">
                <base-btn-outline @click="this.$refs.slideOverDialogAttributesGroup.setIsOpen(true)"
                    btn-icon="PlusIcon" btn-label="Add Attribute Group" btn-color="indigo"/>
                
            </div>
        </div>
        <div class="flex flex-col pt-5">
            <base-table-wrap>
                <base-table>
                    <thead class="bg-gray-50">
                    <tr>
                        <base-table-header>Name</base-table-header>
                        <base-table-header-end>Action</base-table-header-end>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, indexItem) in listOfAttributesGroup" :key="indexItem" :class="(indexItem % 2 == 0) ? 'bg-white':'bg-gray-50'">
                                <base-table-data>
                                <span v-if="item.name">{{ item.name }}</span>
                                <span v-else>Not Set</span>
                            </base-table-data>
                            <base-table-data :class="'text-right'">

                                <base-drop-down :list-of-item="[
                                    { icon : 'EyeIcon',  description : 'Details', okFunction: ()=>{ goToDetailsAttribute(item.id); }, disabled: false, },
                                    { icon : 'TrashIcon',  description : 'Delete', okFunction: ()=>{ deleteAttribute(item.id); }, disabled: false, },
                                ]">
                                    <base-heroicon computed-icon="DotsHorizontalIcon"/>
                                </base-drop-down>

                            </base-table-data>

                        </tr>
                    </tbody>
                </base-table>
                <base-table-no-results-found v-if="!listOfAttributesGroup.length"/>
            </base-table-wrap>
        </div>
        <slide-over-dialog-attributes-group ref="slideOverDialogAttributesGroup" @refreshAttributesGroup="searchAttribute"/>
</template>

<script>
    import BaseConsoleBreadcrumb from "@components/breadcrumb/BaseConsoleBreadcrumb";
    import BaseBtnContainer from "@components/BaseBtnContainer";
    import BaseBtn from "@components/BaseBtn";
    import BaseBtnOutline from "@components/BaseBtnOutline";
    import BaseTableNoResultsFound from "@components/BaseTableNoResultsFound";
    import BaseTable from "@components/table/BaseTable";
    import BaseTableWrap from "@components/table/BaseTableWrap";
    import BaseTableHeader from "@components/table/BaseTableHeader";
    import uiService from "@services/ui-service.js";
    import attributesGroupService from "@services/attribute-group-service.js";
    import BaseTableData from "@components/table/BaseTableData";
    import BaseTableHeaderEnd from "@components/table/BaseTableHeaderEnd";
    import BaseHeroicon from "@components/BaseHeroicon";
    import BaseDropDown from "@components/BaseDropDown";
    import SlideOverDialogAttributesGroup from "@views/console/slide-over-dialog/SlideOverDialogAttributesGroup";
    export default {
        name: 'attribute-list',
        components: {
            BaseHeroicon, BaseDropDown,BaseTableHeaderEnd, BaseTableData, BaseTableHeader,
            BaseTableWrap, BaseTable,BaseBtn, BaseBtnOutline, BaseBtnContainer, BaseConsoleBreadcrumb, BaseTableNoResultsFound,
            SlideOverDialogAttributesGroup,
        },
        data() {
            return {
                listOfAttributesGroup: [],
            }
        },
        async created() {
            // console.log('About to get Item List');
            await this.searchAttribute();
        },
        methods: {
            async searchAttribute() {
                attributesGroupService.search({q:''}, (result)=>{
                    this.listOfAttributesGroup = result.returnData.list_of_items;
                });
            },
            async goToDetailsAttribute(id){
                this.$refs.slideOverDialogAttributesGroup.setIsOpen(true, id);
            },
            async deleteAttribute(id){
                uiService.confirmDelete(()=>{
                    attributesGroupService.delete(id, (results)=>{
                        uiService.showSuccess('Deleted!', results.errorMessage);
                        this.$forceUpdate()
                        this.searchAttribute()
                    });
                });
            },
        },

    }
</script>

<style>

</style>