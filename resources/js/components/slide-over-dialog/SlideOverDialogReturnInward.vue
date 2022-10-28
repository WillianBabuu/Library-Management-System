<template>
    <TransitionRoot appear :show="isOpen" as="template">

        <Dialog
            :initialFocus="returnProductBtnRef"
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
                        <DialogTitle class="text-xl font-bold">Return Products</DialogTitle>
                        <button class="p-1 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="setIsOpen(false)">
                            <base-heroicon computed-icon="XIcon"/>
                        </button>
                    </div>
                    

                    <form class="flex-1 flex flex-col" @submit.prevent="returnProduct">

                        <div class="flex-1 relative">

                            <div class="absolute inset-0 overflow-y-scroll  py-6 px-4">
                                <div class="relative w-full group">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-800">Quantity</label>
                                    <input type="number" id="name" v-model="form.return_quantity" class="box-border text-black placeholder-gray-400
                                text-sm rounded-lg bg-white border border-gray-200 border-solid
                                rounded outline-none focus:ring-indigo-400 focus:border-indigo-400 block w-full p-2.5"
                                           placeholder="quantity" :max="form.quantity" />
                                </div>

                            </div>
                        </div>

                        <div class="py-6 px-4 bg-gray-50">
                            <div class="flex flex-col">
                                <base-btn ref="returnProductBtnRef" btn-label="Save Item Details" btn-icon="SaveIcon" btn-color="indigo"/>
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
    import itemSaleService from "@services/item-sale-service.js";
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
                    id: '', form_method: '', return_quantity: 0, quantity: 0, returning: true,
                },
                listOfCategoryType : Object.values(CategoryType),
                listOfCategories: [],
                isOpen: false,
                returnProductBtnRef: null,
                listPrices: {
                    buying_price: null,
                    selling_price: null
                }
            };
        },
        methods: {
            async returnProduct() {
                itemSaleService.action(this.form, (results)=>{
                    this.isOpen = false;
                    const category = results.returnData;
                    this.$emit("refreshDocumentItems")
                    this.form = {
                       id: '',  expire_at: 0,quantity: 0
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

            setIsOpen(value, item = null) {
                // console.log("Opening Slide Over Dialog Category");
                this.isOpen = value;
                if(item) {
                    this.form.id = item.id;
                    this.form.return_quantity = item.quantity;
                    this.form.quantity = item.quantity;
                    this.form.form_method = 'update';
                }
            },
        },
        created() {}
    }
</script>

<style>
</style>
