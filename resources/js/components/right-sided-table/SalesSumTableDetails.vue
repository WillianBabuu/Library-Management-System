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
                    <base-table-data>Total Amount</base-table-data>
                    <base-table-data >{{ totalItem }}</base-table-data>
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
    import saleService from "@services/sale-service.js";
    import cartService from "@services/cart-service.js";
    import customerService from "@services/customer-service.js";
    import uiService from "@services/ui-service.js";
    export default {
        props: ['documentItems','store_id'],
        components: {
            BaseTableHeaderEnd, BaseTableData, BaseTableHeader,
            BaseTableWrap, BaseTable
        },
        data() {
            return {
                doc: {
                    cart_id: '', form_method:'save', amount: this.totalItem, quantity: this.totalQty, discount:'', status: 2,store_id:''
                },
                customer:{
                   form_method:'update', id:'', customer_id: '', add_customer : true
                },
                listOfItem: [],
                search: '',
            }
        },
        computed: {
            totalItem: function(){
                let sum = 0;
                for(let i = 0; i < this.documentItems.length; i++){
                    sum += (parseFloat(this.documentItems[i].selling_price) * parseFloat(this.documentItems[i].quantity));
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
                    return this.listOfSearchedItem.filter(function(itemFilter){
                        return itemFilter.first_name.toLowerCase().indexOf(self.search.toLowerCase()) !== -1 || 
                                itemFilter.last_name.toLowerCase().indexOf(self.search.toLowerCase()) !== -1 
                    })
                }else{
                    return {};
                }

            },
        },
        methods: {
            async saveSales(){
                this.doc.cart_id = this.$route.params.id
                this.doc.amount = this.totalItem
                this.doc.quantity = this.totalQty
                this.doc.store_id = this.store_id
                saleService.recordSale(this.doc, (results)=>{
                    this.$router.push({ name: 'sales' });
                   
                })
            },
            async searchItem() {
                customerService.search({q:''}, (result)=>{
                    this.listOfSearchedItem = result.returnData.list_of_items;
                });
            },
            async addCustomer(id){
                this.customer.id = this.$route.params.id
                this.customer.customer_id = id
                cartService.action(this.customer, (result)=>{
                    this.$forceUpdate()
                    this.searchSale()
                    this.search = ''
                });
            },
            async searchSale() {
                const id = this.$route.params.id
                cartService.search({id : id}, (result)=>{
                    this.salesData = result.returnData.list_of_items;
                });
            },
            async discardPurchases() {
                const id = this.$route.params.id
                uiService.confirmDelete(()=>{
                    cartService.delete(id, (result)=>{
                        this.$router.push({ name: 'sales' });
                    });
                });
            },
        },
        async created() {
            await this.searchItem();
            await this.searchSale();
        },

    }
</script>

<style>

</style>