<template>
    <TransitionRoot appear :show="isOpen" as="template">

        <Dialog
            :initialFocus="savePriceQuantityBtnRef"
            class="fixed inset-0 overflow-hidden z-10"
            :open="isOpen" @close="setIsOpen">

       
            <TransitionChild
                enter="transform ease-in-out transition-transform duration-300"
                enter-from="translate-x-full"
                enter-to="translate-x-0"
                leave="transform ease-in-out transition-transform duration-300"
                leave-from="translate-x-0"
                leave-to="translate-x-full"
                as="template">

                <div class="flex flex-col bg-white fixed inset-y-0 right-0 w-full max-w-sm">

                    <div class="flex justify-between items-center p-4 shadow border-t-8 border-solid rounded border-indigo-400">
                        <DialogTitle class="text-xl font-bold">Add Item Quantity </DialogTitle>
                        <button class="p-1 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="setIsOpen(false)">
                            <base-heroicon computed-icon="XIcon"/>
                        </button>
                    </div>

                    <form class="flex-1 flex flex-col" @submit.prevent="savePriceQuantity">

                        <div class="flex-1 relative">

                            <div class="absolute inset-0 overflow-y-scroll  py-6 px-4">
                          
                                <div class="relative w-full group">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-800">Quantity</label>
                                    <input type="text" id="name" v-model="form.quantity" class="box-border text-black placeholder-gray-400
                                text-sm rounded-lg bg-white border border-gray-200 border-solid
                                rounded outline-none focus:ring-indigo-400 focus:border-indigo-400 block w-full p-2.5"
                                           placeholder="quantity" />
                                </div>

                            </div>
                        </div>

                        <div class="py-6 px-4 bg-gray-50">
                            <div class="flex flex-col">
                                <base-btn ref="savePriceQuantityBtnRef" btn-label="Save Item Details" btn-icon="SaveIcon" btn-color="indigo"/>
                            </div>
                        </div>

                    </form>

                </div>

            </TransitionChild>

        </Dialog>

    </TransitionRoot>
</template>

<script>
    import { ref } from 'vue';
    import { TransitionRoot, TransitionChild, Dialog, DialogOverlay, DialogTitle, DialogDescription, } from '@headlessui/vue';
    import BaseHeroicon from "../BaseHeroicon";
    import BaseBtn from "../BaseBtn";
    import Swal from "sweetalert2";
    import itemRfqService from "@services/item-rfq-service.js";
    import priceService from "@services/prices-service.js";
    import BaseSelectList from "../BaseSelectList";
    import CategoryType from "@models/enums/category-type";

    export default {
        name: 'slide-over-dialog-category',
        components: {
            BaseSelectList,
            BaseBtn,
            BaseHeroicon,
            TransitionRoot, TransitionChild, Dialog, DialogOverlay, DialogTitle, DialogDescription,
        },
        data() {
            return {
                form: {
                    id: '', form_method: '', quantity: 0, rfq_id: '', item_id: '',
                },
                listOfCategoryType : Object.values(CategoryType),
                listOfCategories: [],
                isOpen: false,
                savePriceQuantityBtnRef: null,
                listPrices: {
                    buying_price: null,
                }
            };
        },
        methods: {
            async savePriceQuantity() {
                if (this.isSales){
                    itemRfqService.action(this.form, (results)=>{
                        this.isOpen = false;
                        this.isSales = false;
                        const category = results.returnData;
                        this.$emit("refreshDocumentItems")
                        this.form = {
                        id: '', amount: 0,quantity: 0
                        }
                        Swal.fire({
                            title: 'Congraturations',
                            text: results.errorMessage,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Okay!'
                        }).then((result) => {
                            this.isOpen = false;
                            this.$emit("refreshDocumentItems");
                        });
                    });
                }else {
                    itemRfqService.action(this.form, (results)=>{
                        this.isOpen = false;
                        this.isSales = false;
                        const category = results.returnData;
                        this.$emit("refreshDocumentItems")
                        this.form = {
                        id: '', amount: 0,quantity: 0
                        }
                        Swal.fire({
                            title: 'Congraturations',
                            text: results.errorMessage,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Okay!'
                        }).then((result) => {
                            this.isOpen = false;
                            this.$emit("refreshDocumentItems");
                        });
                    });
                }
            },

            setIsOpen(value, isSales,item = null) {
                // console.log("Opening Slide Over Dialog Category");
                this.isOpen = value;
                this.isSales = isSales
                if(item) {
                    this.form.id = item.id;
                    this.form.rfq_id = item.rfq_id;
                    this.form.item_id = item.item_id;
                    this.form.form_method = 'update';
                    this.form.amount = item.amount;
                    this.form.quantity = item.quantity;

                    if(!isSales){
                        this.getLastBuyingPrice(item)
                    }
                }
            },

            async getLastBuyingPrice(item){
                priceService.search({item_id: item.item_id}, (result)=>{
                    if(result.returnData != null){
                        this.listPrices = result.returnData.list_of_items;
                    }else{
                            this.form.amount = item.amount;
                            this.listPrices.buying_price = null;
                        }

                });
            }
        },
        created() {}
    }
</script>

<style>
</style>
