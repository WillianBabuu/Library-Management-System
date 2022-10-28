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
                        <tr v-for="(item, indexItem) in listOfSale" :key="indexItem" :class="(indexItem % 2 == 0) ? 'bg-white':'bg-gray-50'">
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

                                <div>
                                    <Menu as="div" class="relative inline-block h-full text-right">
                                        <MenuButton class="inline-flex w-full text-sm font-medium">
                                            <base-heroicon computed-icon="DotsHorizontalIcon"/>
                                        </MenuButton>

                                        <div class="fixed">
                                            <transition
                                                enter-active-class="transition duration-100 ease-out"
                                                enter-from-class="transform scale-95 opacity-0"
                                                enter-to-class="transform scale-100 opacity-100"
                                                leave-active-class="transition duration-75 ease-in"
                                                leave-from-class="transform scale-100 opacity-100"
                                                leave-to-class="transform scale-95 opacity-0">

                                                <MenuItems
                                                    class="-top-2 z-10 absolute right-0 w-56 mt-2 origin-top-right
                                                    bg-white divide-y divide-gray-100 rounded-md shadow-lg
                                                    ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                    <div class="px-1 py-1">
                                                        <MenuItem v-slot="{ active }">
                                                            <button @click="goToDetailsReturning(item.id)"
                                                                :class="[
                                                                        active ? 'bg-indigo-500 text-white' : 'text-gray-900',
                                                                        'group flex rounded-md items-center w-full px-2 py-2 text-sm',
                                                                    ]">
                                                                <base-heroicon :active="active" computed-icon="EyeIcon" :class="'mr-2 text-indigo-400'"/>
                                                                Details
                                                            </button>
                                                        </MenuItem>
                                                    </div>

                                                    <div class="px-1 py-1">
                                                        <MenuItem v-slot="{ active }">
                                                            <button @click="deleteReturning(item.id)"
                                                                :class="[
                                                                        active ? 'bg-indigo-500 text-white' : 'text-gray-900',
                                                                        'group flex rounded-md items-center w-full px-2 py-2 text-sm',
                                                                    ]">
                                                                <base-heroicon :active="active" computed-icon="TrashIcon" :class="'mr-2 text-indigo-400'"/>
                                                                Delete
                                                            </button>
                                                        </MenuItem>
                                                    </div>
                                                </MenuItems>
                                            </transition>
                                        </div>

                                    </Menu>
                                </div>


                            </base-table-data>

                        </tr>
                    </tbody>
                </base-table>
                <base-table-no-results-found v-if="!listOfSale.length"/>
            </base-table-wrap>
        </div>
    </div>
</template>

<script>
    import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
    import ConsoleLayout from "@layout/ConsoleLayout";
    import BaseConsoleBreadcrumb from "@components/breadcrumb/BaseConsoleBreadcrumb";
    import BaseBtnContainer from "@components/BaseBtnContainer";
    import BaseBtn from "@components/BaseBtn";
    import BaseTableNoResultsFound from "@components/BaseTableNoResultsFound";
    import BaseTable from "@components/table/BaseTable";
    import BaseTableWrap from "@components/table/BaseTableWrap";
    import BaseTableHeader from "@components/table/BaseTableHeader";
    import uiService from "@services/ui-service.js";
    import saleService from "@services/sale-service.js";
    import returninginwardService from "@services/returninginward-service.js";
    import BaseTableData from "@components/table/BaseTableData";
    import BaseTableHeaderEnd from "@components/table/BaseTableHeaderEnd";
    import BaseHeroicon from "@components/BaseHeroicon";

    export default {
        name: 'returning-list',
        components: {
            BaseHeroicon,
            BaseTableHeaderEnd, BaseTableData, BaseTableHeader,
            BaseTableWrap, BaseTable,
            BaseBtn,
            BaseBtnContainer,
            BaseConsoleBreadcrumb,
            BaseTableNoResultsFound,
            ConsoleLayout,
            Menu, MenuButton, MenuItems, MenuItem,
        },
        data() {
            return {
                listOfSale: [],
            }
        },
        async created() {
            // console.log('About to get Item List');
            await this.searchReturning();
        },
        methods: {
            async searchReturning() {
                saleService.search({q: ''}, (result)=>{
                    this.listOfSale = result.returnData.list_of_items;
                });
            },
            async toWaitingRecievings(){
                this.$router.push({ name: 'returninginward-list' });
            },
            async goToDetailsReturning(id){
                this.$router.push({ name: 'returninginward-add', params: { id:id } });
            },
            async deleteReturning(id){
                uiService.confirmDelete(()=>{
                    returninginwardService.delete(id, (results)=>{
                        uiService.showSuccess('Deleted!', results.errorMessage);
                        this.$forceUpdate()
                        this.searchReturning()
                    });
                });
            },
        },
    }
</script>

<style>
</style>
