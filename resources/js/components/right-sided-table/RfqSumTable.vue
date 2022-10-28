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
                        <ul>
                            <li v-for="(supplier, indexItem) in purchasesData.suppliers" :key="indexItem">
                                <span v-if="supplier.type == 1 ">{{ supplier.company_name }}</span>
                                <span v-else>{{ supplier.first_name }} {{ supplier.last_name }}</span>
                            </li>
                            <!-- <span >No Supplier Selected</span> -->
                        </ul>
                    </base-table-data>
                </tr>
                <tr class="bg-gray-50">
                    <base-table-data>Doc Number</base-table-data>
                    <base-table-data>
                        {{ purchasesData.doc_no }}
                    </base-table-data>
                </tr>
                <tr class="bg-gray-50">
                    <base-table-data>Total Quantity</base-table-data>
                    <base-table-data >{{ totalQty }}</base-table-data>
                </tr>
                <tr class="bg-white" v-if="!isDetail">
                    <base-table-data>
                        <button type="button" @click="saveRfq()" class="h-10 px-2 text-white transition-colors duration-150 bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800">
                           Save RFQ
                        </button>
                    </base-table-data>
                    <base-table-data >
                        <button type="button" @click="discardRfq()" class="h-10 px-2 text-white transition-colors duration-150 bg-red-700 rounded-lg focus:shadow-outline hover:bg-red-800">
                           Discard RFQ
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
    import rfqService from "@services/rfq-service.js";
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
                    id: '', form_method:'update', quantity: this.totalQty, discount:'', status: 2,
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
            async saveRfq(){
                this.doc.id = this.$route.params.id
                this.doc.amount = this.totalItem
                this.doc.quantity = this.totalQty
                this.doc.form_method = 'update'
                rfqService.action(this.doc, (results)=>{
                    this.$router.push({ name: 'rfq-list' });
                   
                })
            },
            async addSupplier(id){
                this.supplier.id = this.$route.params.id
                this.supplier.supplier_id = id
                rfqService.action(this.supplier, (result)=>{
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
                rfqService.get({id : id}, (result)=>{
                    this.purchasesData = result.returnData.item;
                });
            },
            async discardRfq() {
                const id = this.$route.params.id
                uiService.confirmDelete(()=>{
                    rfqService.delete(id, (result)=>{
                        this.$router.push({ name: 'rfq-list' });
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