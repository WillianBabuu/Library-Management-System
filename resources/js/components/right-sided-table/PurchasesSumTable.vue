<template>
    <div>
        <div class="relative flex items-center text-gray-400 focus-within:text-gray-600" v-if="!isDetail">
            <div class=" w-full">
                <input type="text" v-model="search" placeholder="Search for suppliers in your company" autocomplete="off" aria-label="Search"
                    class="focus:outline-none block w-full pr-3 pl-10 py-2 font-semibold placeholder-gray-500 text-black rounded-md md:border-none ring-1 ring-gray-300 focus:ring-2 focus:ring-gray-500">
                <div class="absolute w-full z-50 bg-white border border-gray-300 mt-1 mh-48 overflow-hidden overflow-y-scroll rounded-md shadow-md" >
                    <ul>
                        <li v-for="(item, index) in matchingItems" :key="index" @click="addSupplier(item.id)"
                            class="px-3 py-2 cursor-pointer hover:bg-gray-200 text-center">
                            <span v-if="item.type == 1">{{ item.company_name }}</span>
                            <span v-else>{{ item.first_name }} {{ item.last_name }}</span>
                            
                        </li>
                        <li v-if="search && !matchingItems.length" class="px-3 py-2 text-center">
                            No Matching Results
                        </li>
                    </ul>
                </div>
            </div>
        </div>
     <base-table-wrap>
        <base-table>
           <tbody>
               <tr class="bg-gray-50">
                   <base-table-data>Supplier</base-table-data>
                    <base-table-data >
                        <div v-for="(purchase, indexItem) in purchasesData" :key="indexItem">
                            <span v-if="purchase.supplier_id ">
                                <span v-if="purchase.supplier.type == 1 ">{{ purchase.supplier.company_name }}</span>
                                <span v-else>{{ purchase.supplier.first_name }} {{ purchase.supplier.last_name }}</span>
                                
                                </span>
                            <span v-else>No Supplier Selected</span>
                        </div>
                    </base-table-data>
                </tr>
                <tr class="bg-gray-50">
                    <base-table-data>Doc Number</base-table-data>
                    <base-table-data v-for="(purchase, indexItem) in purchasesData" :key="indexItem">
                        {{ purchase.doc_no }}
                    </base-table-data>
                </tr>
                <tr class="bg-gray-50">
                    <base-table-data>Total Quantity</base-table-data>
                    <base-table-data >{{ totalQty }}</base-table-data>
                </tr>
                <tr class="bg-gray-50">
                    <base-table-data>Total Amount</base-table-data>
                    <base-table-data >{{ totalItem }}</base-table-data>
                </tr>
                <tr class="bg-white" v-if="!isDetail">
                    <base-table-data>
                        <button type="button" @click="savePurchases()" class="h-10 px-2 text-white transition-colors duration-150 bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800">
                           Save Purchase
                        </button>
                    </base-table-data>
                    <base-table-data >
                        <button type="button" @click="discardPurchases()" class="h-10 px-2 text-white transition-colors duration-150 bg-red-700 rounded-lg focus:shadow-outline hover:bg-red-800">
                           Discard Purchase
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
        props: ['documentItems','isDetail'],
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
                    id: '', form_method:'update', amount: this.totalItem, quantity: this.totalQty, discount:'', status: 2,
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
                    this.$router.push({ name: 'purchases-list' });
                   
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
                        this.$router.push({ name: 'purchases-list' });
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