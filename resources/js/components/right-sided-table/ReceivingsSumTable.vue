<template>
    <div>
     <base-table-wrap>
        <base-table>
           <tbody>
                <tr class="bg-gray-50">
                    <base-table-data>Total Quantity</base-table-data>
                    <base-table-data >{{ totalQty }}</base-table-data>
                </tr>
                <tr class="bg-gray-50">
                    <base-table-data>Total Amounttt</base-table-data>
                    <base-table-data >{{ totalItem }}</base-table-data>
                </tr>
                <tr class="bg-white">
                    <base-table-data>
                        <button type="button" @click="savePurchases()" class="h-10 px-2 text-white transition-colors duration-150 bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800">
                           Save Receiving
                        </button>
                    </base-table-data>
                    <base-table-data >
                        <button type="button" @click="discardPurchases()" class="h-10 px-2 text-white transition-colors duration-150 bg-red-700 rounded-lg focus:shadow-outline hover:bg-red-800">
                           Discard Receiving
                        </button>
                    </base-table-data>
                </tr>
            </tbody>
        </base-table>
        <!-- <base-table-no-results-found v-if="!documentItems.length"/> -->
    </base-table-wrap> 
    </div>
</template>

<script>
    import BaseTable from "@components/table/BaseTable";
    import BaseTableWrap from "@components/table/BaseTableWrap";
    import BaseTableHeader from "@components/table/BaseTableHeader";
    import BaseTableHeaderEnd from "@components/table/BaseTableHeaderEnd";
    import BaseTableData from "@components/table/BaseTableData";
    import purchaseService from "@services/purchase-service.js";
    import supplierService from "@services/supplier-service.js";
    import uiService from "@services/ui-service.js";
    export default {
        props: ['documentItems'],
        components: {
            BaseTableHeaderEnd, BaseTableData, BaseTableHeader,
            BaseTableWrap, BaseTable
        },
        data() {
            return {
                supplier:{
                    id: '', form_method:'update',supplier_id: '', add_supplier : true
                },
                doc: {
                    id: '', form_method:'update', amount: this.totalItem, quantity: this.totalQty, discount:'', status: 4,
                },
                listOfSearchedSuppliers:[],
                search: '',
                purchasesData: []
            }
        },
        computed: {
            totalItem: function(){
                let sum = 0;
                for(let i = 0; i < this.documentItems.length; i++){
                    sum += (parseFloat(this.documentItems[i].amount) * parseFloat(this.documentItems[i].quantity));
                }
                return sum;
            },
            totalQty: function(){
                let sum = 0;
                for(let i = 0; i < this.documentItems.length; i++){
                    sum += (parseFloat(this.documentItems[i].quantity));
                }
                return sum;
            },
            matchingItems: function(){
                var self = this
                if (this.search) {
                    return this.listOfSearchedSuppliers.filter(function(itemFilter){
                        return itemFilter.first_name.toLowerCase().indexOf(self.search.toLowerCase()) !== -1 || itemFilter.last_name.toLowerCase().indexOf(self.search.toLowerCase()) !== -1 
                    })
                }else{
                    return {};
                }

            },
        },
        methods: {
            async savePurchases(){
                this.doc.id = this.$route.params.id
                this.doc.amount = this.totalItem
                this.doc.quantity = this.totalQty
                this.doc.form_method = 'update'
                purchaseService.action(this.doc, (results)=>{
                    this.$router.push({ name: 'receiving-list' });
                   
                })
            },
            async addSupplier(id){
                this.supplier.id = this.$route.params.id
                this.supplier.supplier_id = id
                purchaseService.action(this.supplier, (result)=>{
                    this.$forceUpdate()
                    this.searchPurchase()
                    this.search = ''
                });
            },
            async searchSuppliers() {
                supplierService.search({q:''}, (result)=>{
                    this.listOfSearchedSuppliers = result.returnData.list_of_items;
                });
            },
            async searchPurchase() {
                const id = this.$route.params.id
                purchaseService.search({id : id}, (result)=>{
                    this.purchasesData = result.returnData.list_of_items;
                });
            },
            async discardPurchases() {
                const id = this.$route.params.id
                uiService.confirmDelete(()=>{
                    purchaseService.delete(id, (result)=>{
                        this.$router.push({ name: 'receiving-list' });
                    });
                });
            },
        },
        async created() {
            await this.searchSuppliers();
            await this.searchPurchase();
        },

    }
</script>

<style>

</style>