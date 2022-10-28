<template>

    <div>
        <div class="flex flex-col pt-5">
            <base-table-wrap>
                <base-table>
                    <thead class="bg-gray-50">
                    <tr>
                        <base-table-header>Amount</base-table-header>
                        <base-table-header>Quantity</base-table-header>
                        <base-table-header>Discount</base-table-header>
                        <base-table-header>Supplier</base-table-header>
                        <base-table-header-end>Action</base-table-header-end>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, indexItem) in listOfReceiving" :key="indexItem" :class="(indexItem % 2 == 0) ? 'bg-white':'bg-gray-50'">
                            <base-table-data>{{ item.amount }}</base-table-data>
                            <base-table-data>{{ item.quantity }}</base-table-data>
                            <base-table-data>
                                <span v-if="item.discount">{{ item.discount }}</span>
                                <span v-else>No Discount</span>
                            </base-table-data>
                            <base-table-data>
                                <span v-if="item.supplier_id">
                                    <span v-if="item.supplier.type == 1 ">{{ item.supplier.company_name }}</span>
                                    <span v-else>{{ item.supplier.first_name }} {{ item.supplier.last_name }}</span>
                                </span>
                                <span v-else>No Specific Supplier</span>
                            </base-table-data>
                            <base-table-data :class="'text-right'">

                                <base-drop-down :list-of-item="[
                                        { icon : 'EyeIcon',  description : 'Details', okFunction: ()=>{ goToDetailsReceiving(item.id); }, disabled: false, },
                                        { icon : 'TrashIcon',  description : 'Delete', okFunction: ()=>{ deleteReceiving(item.id); }, disabled: false, },
                                    ]">
                                    <base-heroicon computed-icon="DotsHorizontalIcon"/>
                                </base-drop-down>

                            </base-table-data>

                        </tr>
                    </tbody>
                </base-table>
                <base-table-no-results-found v-if="!listOfReceiving.length"/>
            </base-table-wrap>
        </div>
    </div>
</template>

<script>
    import BaseConsoleBreadcrumb from "@components/breadcrumb/BaseConsoleBreadcrumb";
    import BaseBtnContainer from "@components/BaseBtnContainer";
    import BaseBtn from "@components/BaseBtn";
    import BaseTableNoResultsFound from "@components/BaseTableNoResultsFound";
    import BaseTable from "@components/table/BaseTable";
    import BaseTableWrap from "@components/table/BaseTableWrap";
    import BaseTableHeader from "@components/table/BaseTableHeader";
    import uiService from "@services/ui-service.js";
    import purchaseService from "@services/purchase-service.js";
    import receivingService from "@services/receiving-service.js";
    import BaseTableData from "@components/table/BaseTableData";
    import BaseTableHeaderEnd from "@components/table/BaseTableHeaderEnd";
    import BaseHeroicon from "@components/BaseHeroicon";
    import BaseDropDown from "@components/BaseDropDown";

    export default {
        name: 'receiving-list',
        components: {
            BaseHeroicon, BaseDropDown,
            BaseTableHeaderEnd, BaseTableData, BaseTableHeader,
            BaseTableWrap, BaseTable, BaseBtn, BaseBtnContainer,
            BaseConsoleBreadcrumb,BaseTableNoResultsFound,
        },
        data() {
            return {
                listOfReceiving: [],
            }
        },
        async created() {
            // console.log('About to get Item List');
            await this.searchReceiving();
        },
        methods: {
            async searchReceiving() {
                purchaseService.search({status: 2}, (result)=>{
                    this.listOfReceiving = result.returnData.list_of_items;
                });
            },
            async toAllRecieving(){
                this.$router.push({ name: 'receivings-all' });
            },
            async goToDetailsReceiving(id){
                this.$router.push({ name: 'receivings-confirm', params: { id:id } });
            },
            async deleteReceiving(id){
                uiService.confirmDelete(()=>{
                    receivingService.delete(id, (results)=>{
                        uiService.showSuccess('Deleted!', results.errorMessage);
                        this.$forceUpdate()
                        this.searchReceiving()
                    });
                });
            },
        },
    }
</script>

<style>
</style>
