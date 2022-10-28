<template>


    <div class="flex flex-col pt-5">
        <base-table-wrap>
            <base-table>
                <thead class="bg-gray-50">
                <tr>
                    <base-table-header>Amount</base-table-header>
                    <base-table-header>Quantity</base-table-header>
                    <base-table-header>Discount</base-table-header>
                    <base-table-header>Supplier</base-table-header>
                    <base-table-header>Status</base-table-header>
                    <base-table-header-end>Action</base-table-header-end>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, indexItem) in listOfCart" :key="indexItem" :class="(indexItem % 2 == 0) ? 'bg-white':'bg-gray-50'">
                        <base-table-data>
                            <span v-if="item.amount">{{ item.amount }}</span>
                            <span v-else>Not Set</span>
                        </base-table-data>
                        <base-table-data>
                            <span v-if="item.amount">{{ item.quantity }}</span>
                            <span v-else>Not Set</span>
                        </base-table-data>
                        <base-table-data>
                            <span v-if="item.discount">{{ item.discount }}</span>
                            <span v-else>No Discount</span>
                        </base-table-data>
                        <base-table-data>
                            <span v-if="item.supplier_id">{{ item.supplier_id }}</span>
                            <span v-else>No Specific Supplier</span>
                        </base-table-data>
                        <base-table-data>
                            <span v-if="item.status == 2" class="p-1 text-white bg-green-400 rounded">Sold</span>
                            <span v-else class="p-1 text-white bg-indigo-400 rounded">Pending</span>
                        </base-table-data>
                        <base-table-data :class="'text-right'">

                            <base-drop-down :list-of-item="[
                                        { icon : 'EyeIcon',  description : 'Details', okFunction: ()=>{ goToDetailsCart(item.id); }, disabled: false, },
                                        { icon : 'TrashIcon',  description : 'Delete', okFunction: ()=>{ deleteCart(item.id); }, disabled: false, },
                                    ]">
                                <base-heroicon computed-icon="DotsHorizontalIcon"/>
                            </base-drop-down>


                        </base-table-data>

                    </tr>
                </tbody>
            </base-table>
            <base-table-no-results-found v-if="!listOfCart.length"/>
        </base-table-wrap>
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
    import itemService from "@services/item-service.js";
    import cartService from "@services/cart-service.js";
    import BaseTableData from "@components/table/BaseTableData";
    import BaseTableHeaderEnd from "@components/table/BaseTableHeaderEnd";
    import BaseHeroicon from "@components/BaseHeroicon";
    import BaseDropDown from "@components/BaseDropDown";

    export default {
        name: 'cart-list',
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
                listOfCart: [],
            }
        },
        async created() {
            // console.log('About to get Item List');
            await this.searchCart();
        },
        methods: {
            async searchCart() {
                cartService.search({status: 0}, (result)=>{
                    this.listOfCart = result.returnData.list_of_items;
                });
            },
            async goToCart(){
                cartService.action(this.form, (results)=>{
                    this.$router.push({ name: 'cart-add', params: { id:results.returnData.id } });
                })
                //
            },
            async goToDetailsCart(id){
                this.$router.push({ name: 'cart-add', params: { id:id } });
            },
            async deleteCart(id){
                uiService.confirmDelete(()=>{
                    cartService.delete(id, (results)=>{
                        uiService.showSuccess('Deleted!', results.errorMessage);
                        this.$forceUpdate()
                        this.searchCart()
                    });
                });
            },
        },
    }
</script>

<style>
</style>
