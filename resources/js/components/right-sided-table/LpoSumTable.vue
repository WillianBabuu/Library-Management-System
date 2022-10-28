<template>
    <div>
     <base-table-wrap>
        <base-table>
           <tbody>
               <tr class="bg-gray-50">
                   <base-table-data>Supplier:</base-table-data>
                    <base-table-data >
                        <ul>
                            <li v-if="lpoData.supplier_id">
                                <span v-if="lpoData.supplier.type == 1 ">{{ lpoData.supplier.company_name }}</span>
                                <span v-else>{{ lpoData.supplier.first_name }} {{ lpoData.supplier.last_name }}</span>
                            </li>
                            <span v-else>No Supplier Selected</span>
                        </ul>
                    </base-table-data>
                    <base-table-data>Doc Number</base-table-data>
                    <base-table-data>
                        {{ lpoData.doc_no }}
                    </base-table-data>
                </tr>
                <tr class="bg-gray-50">
                    <base-table-data>Total Quantity</base-table-data>
                    <base-table-data >{{ totalQty }}</base-table-data>
                    <base-table-data>Total Amount</base-table-data>
                    <base-table-data >{{ totalItem }}</base-table-data>
                </tr>
                
                <tr class="bg-white" v-if="!isDetail">
                    <base-table-data>Receiving Store </base-table-data>
                    <base-table-data >
                        <!-- <base-select-list  id="category_id" key-description="name" key-value="id" :list-of-item="listOfStores" default-selection="-- SELECT STORE --" v-model="doc.store" :selected-item-id="doc.store" /> -->
                        <select v-model="doc.store" class="box-border text-black placeholder-gray-400 text-sm rounded-lg bg-white border border-gray-200 border-solid rounded outline-none focus:ring-indigo-400 focus:border-indigo-400 block w-full p-2.5">
                            <option value="">-- SELECT STORE --</option>
                            <option :value="store.id" v-for="store in listOfStores" :key="store">{{ store.name }}</option>
                        </select>
                    </base-table-data>
                    <base-table-data>
                        <button type="button" @click="saveLpo()" class="h-10 px-2 text-white transition-colors duration-150 bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800">
                           Recieve LPO
                        </button>
                    </base-table-data>
                    <base-table-data >
                        <button type="button" @click="discardLpo()" class="h-10 px-2 text-white transition-colors duration-150 bg-red-700 rounded-lg focus:shadow-outline hover:bg-red-800">
                           Discard LPO
                        </button>
                    </base-table-data>
                </tr>
            </tbody>
        </base-table>
    </base-table-wrap> 
    </div>
</template>

<script>
    import BaseTable from "@components/table/BaseTable";
    import BaseTableWrap from "@components/table/BaseTableWrap";
    import BaseTableHeader from "@components/table/BaseTableHeader";
    import BaseTableHeaderEnd from "@components/table/BaseTableHeaderEnd";
    import BaseTableData from "@components/table/BaseTableData";
    import lpoService from "@services/lpo-service.js";
    import receivingService from "@services/receiving-service.js";
    import storeService from "@services/store-service.js";
    import uiService from "@services/ui-service.js";
    import BaseSelectList from "@components/BaseSelectList";
    export default {
        props: ['documentItems','isDetail', 'lpoData'],
        components: {
            BaseTableHeaderEnd, BaseTableData, BaseTableHeader,
            BaseTableWrap, BaseTable, BaseSelectList
        },
        data() {
            return {
                doc: {
                    id: '', form_method:'update', amount: '', quantity: this.totalQty, discount:'', status: 2, store:''
                },
                listOfSearchedSuppliers:[],
                listOfStores:[],
                search: '',
            }
        },
        computed: {
            totalItem: function(){
                let sum = 0;
                for(let i = 0; i < this.documentItems.length; i++){
                    sum += (parseFloat(this.documentItems[i].buying_price) * parseFloat(this.documentItems[i].quantity));
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
        },
        methods: {
            async saveLpo(){
                this.doc.id = this.$route.params.id
                this.doc.amount = this.totalItem
                this.doc.quantity = this.totalQty
                // this.doc.store = this.doc.store.id
                this.doc.form_method = 'update'
                receivingService.updatePricesLpo(this.doc, (results)=>{
                    this.$router.push({ name: 'lpo-list' });
                   
                })
            },
            async discardLpo() {
                const id = this.$route.params.id
                uiService.confirmDelete(()=>{
                    lpoService.delete(id, (result)=>{
                        this.$router.push({ name: 'lpo-list' });
                    });
                });
            },
            async searchStore() {
                storeService.search({q:''}, (result)=>{
                    this.listOfStores = result.returnData.list_of_items;
                });
            },
        },
        async created() {
            await this.searchStore();
        },

    }
</script>

<style>

</style>