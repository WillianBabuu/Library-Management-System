<template>
    <div>
        <div class="flex flex-col pt-5">
            <base-table-wrap>
                <base-table>
                    <thead class="bg-gray-50">
                    <tr>
                        <base-table-header>Doc Number</base-table-header>
                        <base-table-header>Store Out</base-table-header>
                        <base-table-header>Store In</base-table-header>
                        <base-table-header>Status</base-table-header>
                        <base-table-header-end>Action</base-table-header-end>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, indexItem) in listOfTransfer" :key="indexItem" :class="(indexItem % 2 == 0) ? 'bg-white':'bg-gray-50'">
                            <base-table-data>{{ item.doc_no  }}</base-table-data>
                            <base-table-data>
                                <span v-if="item.store_out_id">{{ item.store_out.name  }}</span>
                                <span v-else>Not Set</span>
                            </base-table-data>
                            <base-table-data>
                            <span v-if="item.store_in_id">{{ item.store_in.name  }}</span>
                            <span v-else>Not Selected</span>
                                
                            </base-table-data>
                            <base-table-data>
                                <span v-if="item.status == 2" class="p-1 text-white bg-green-400 rounded">
                                    Received
                                </span>
                                <span v-else-if="item.status == 1" class="p-1 text-white bg-yellow-400 rounded">
                                    Transfered
                                </span>
                                <span v-else class="p-1 text-white bg-red-400 rounded">
                                    Pending
                                </span>
                            </base-table-data>
                            <base-table-data :class="'text-right'">

                                <base-drop-down :list-of-item="[
                                        { icon : 'EyeIcon',  description : 'Receive', okFunction: ()=>{ goToConfirmTransfer(item.id); }, disabled: false, },
                                         { icon : 'EyeIcon',  description : 'Details', okFunction: ()=>{ goToDetailsTransfer(item.id); }, disabled: false, },
                                        { icon : 'TrashIcon',  description : 'Delete', okFunction: ()=>{ deleteTransfer(item.id); }, disabled: false, },
                                    ]"  v-if="item.status == 1">
                                    <base-heroicon computed-icon="DotsHorizontalIcon"/>
                                </base-drop-down>
                                <base-drop-down :list-of-item="[
                                         { icon : 'EyeIcon',  description : 'Details', okFunction: ()=>{ goToDetailsTransfer(item.id); }, disabled: false, },
                                        { icon : 'TrashIcon',  description : 'Delete', okFunction: ()=>{ deleteTransfer(item.id); }, disabled: false, },
                                    ]"  v-else>
                                    <base-heroicon computed-icon="DotsHorizontalIcon"/>
                                </base-drop-down>

                            </base-table-data>

                        </tr>
                    </tbody>
                </base-table>
                <base-table-no-results-found v-if="!listOfTransfer.length"/>
            </base-table-wrap>
        </div>
    </div>
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
    import uiService from "@services/ui-service.js";
    import transferService from "@services/transfer-service.js";
    import BaseTableData from "@components/table/BaseTableData";
    import BaseTableHeaderEnd from "@components/table/BaseTableHeaderEnd";
    import BaseHeroicon from "@components/BaseHeroicon";
    import BaseDropDown from "@components/BaseDropDown";

    export default {
        name: 'transfer-list',
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
                listOfTransfer: [],
            }
        },
        async created() {
            // console.log('About to get Item List');
            await this.searchTransfer();
        },
        methods: {
            async searchTransfer() {
                transferService.search({status: 1}, (result)=>{
                    this.listOfTransfer = result.returnData.list_of_items;
                });
            },
            async toWaitingRecievings(){
                this.$router.push({ name: 'transfers-list' });
            },
            async goToDetailsTransfer(id){
                this.$router.push({ name: 'transfer-details', params: { id:id } });
            },
            async goToConfirmTransfer(id){
                this.$router.push({ name: 'transfer-confirm', params: { id:id } });
            },
            async deleteTransfer(id){
                uiService.confirmDelete(()=>{
                    transferService.delete(id, (results)=>{
                        uiService.showSuccess('Deleted!', results.errorMessage);
                        this.$forceUpdate()
                        this.searchTransfer()
                    });
                });
            },
        },
    }
</script>

<style>
</style>
