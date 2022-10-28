<template>
    <TransitionRoot appear :show="isOpen" as="template">

        <Dialog
            :initialFocus="savePriceQuantityBtnRef"
            class="fixed inset-0 overflow-hidden z-10"
            :open="isOpen" @close="setIsOpen">

            <TransitionChild
                enter="transition-opacity ease-in-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="transition-opacity ease-in-out duration-300"
                leave-from="opacity-100"
                leave-to="opacity-0"
                as="template">

                <DialogOverlay class="absolute inset-0 bg-black bg-opacity-40"/>

            </TransitionChild>

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
                        <DialogTitle class="text-xl font-bold">Add Price and Quantity </DialogTitle>
                        <button class="p-1 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="setIsOpen(false)">
                            <base-heroicon computed-icon="XIcon"/>
                        </button>
                    </div>

                    <form class="flex-1 flex flex-col" @submit.prevent="updateReceivings">

                        <div class="flex-1 relative">

                            <div class="absolute inset-0 overflow-y-scroll  py-6 px-4">
                                <div class="relative w-full group">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-800">Quantity</label>
                                    <input type="text" id="name" v-model="form.quantity" class="box-border text-black placeholder-gray-400
                                text-sm rounded-lg bg-white border border-gray-200 border-solid
                                rounded outline-none focus:ring-indigo-400 focus:border-indigo-400 block w-full p-2.5"
                                           placeholder="quantity" readonly />
                                </div>
                                <div class="relative w-full group">
                                    <label for="type" class="block mb-2 text-sm font-medium text-gray-800">Buying Price per Item</label>
                                    <input type="text" id="name" v-model="form.buying_price" class="box-border text-black placeholder-gray-400
                                text-sm rounded-lg bg-white border border-gray-200 border-solid
                                rounded outline-none focus:ring-indigo-400 focus:border-indigo-400 block w-full p-2.5"
                                           placeholder="buying_price" readonly />
                                </div>
                                <div class="relative w-full group">
                                    <label for="type" class="block mb-2 text-sm font-medium text-gray-800">Selling Price per Item</label>
                                    <input type="text" id="name" v-model="form.selling_price" class="box-border text-black placeholder-gray-400
                                text-sm rounded-lg bg-white border border-gray-200 border-solid
                                rounded outline-none focus:ring-indigo-400 focus:border-indigo-400 block w-full p-2.5"
                                           placeholder="Enter Selling Price" />
                                </div>

                                

                            </div>
                        </div>

                        <div class="py-6 px-4 bg-gray-50">
                            <div class="flex flex-col">
                                <base-btn ref="savePriceQuantityBtnRef" btn-label="Save Item Prices" btn-icon="SaveIcon" btn-color="indigo"/>
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
    import itemPurchaseService from "@services/item-purchase-service.js";
    import pricesService from "@services/prices-service.js";
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
                    id: '', form_method: '', buying_price: 0, selling_price: 0, quantity: 0, purchase_id: '', item_id: '', amount: '',default: 1,
                },
                listOfCategoryType : Object.values(CategoryType),
                listOfCategories: [],
                isOpen: false,
                savePriceQuantityBtnRef: null
            };
        },
        methods: {
            async savePrices() {
                this.form.form_method = 'save'
                this.form.default = 1
                this.form.item_id = this.$route.params.id;
                pricesService.action(this.form, (results)=>{
                    this.isOpen = false;
                    const category = results.returnData;
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
            },

            async updateReceivings() {
                this.form.form_method = 'update'
                this.form.amount = this.form.buying_price
                itemPurchaseService.action(this.form, (results)=>{
                    this.savePrices();
                    this.$emit("refreshDocumentItems");
                });
            },

            setIsOpen(value, item = null) {
                // console.log("Opening Slide Over Dialog Category");
                this.isOpen = value;
                if(item) {
                    this.form.id = item.id;
                    this.form.purchase_id = item.purchase_id;
                    this.form.item_id = item.item_id;
                    this.form.buying_price = item.amount;
                    this.form.selling_price = item.selling_price;
                    this.form.quantity = item.quantity;
                    this.form.form_method = 'update';
                }
            }
        },
        created() {}
    }
</script>

<style>
</style>
