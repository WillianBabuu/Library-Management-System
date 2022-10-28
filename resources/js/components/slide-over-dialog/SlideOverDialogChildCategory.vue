<template>
    <TransitionRoot appear :show="isOpen" as="template">

        <Dialog
            :initialFocus="saveCategoryBtnRef"
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
                        <DialogTitle class="text-xl font-bold">Child Category Form</DialogTitle>
                        <button class="p-1 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="setIsOpen(false)">
                            <base-heroicon computed-icon="XIcon"/>
                        </button>
                    </div>

                    <form class="flex-1 flex flex-col" @submit.prevent="saveCategory">
                        
                        <div class="flex-1 relative">

                            <div class="absolute inset-0 overflow-y-scroll  py-6 px-4">

                                <div class="relative z-0 w-full group">
                                    <label for="category_id" class="block mb-2 text-sm font-medium text-gray-800">Parent Category</label>
                                    <div class="inline-flex justify-center items-center w-full">
                                        <select id="category_id" v-model="form.parent_id" class="box-border text-black placeholder-gray-400
                                            text-sm rounded-lg bg-white border border-gray-200 border-solid
                                            rounded outline-none focus:ring-indigo-400 focus:border-indigo-400 block w-full p-2.5" disabled="true">
                                            <option value="">Select Parent Category</option>
                                            <option  v-for="(item, indexItem) in listOfCategories" :key="indexItem" :value="item.id">{{ item.name }}</option>
                                        </select>
                                        <base-btn-icon-only @click.prevent="this.$refs.slideOverDialogCategory.setIsOpen(true)" btn-icon="PlusIcon" btn-color="indigo"/>
                                    </div>
                                </div>
                                <div class="relative z-0 w-full group">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-800">Name</label>
                                    <input type="text" id="name" v-model="form.name" class="box-border text-black placeholder-gray-400
                                text-sm rounded-lg bg-white border border-gray-200 border-solid
                                rounded outline-none focus:ring-indigo-400 focus:border-indigo-400 block w-full p-2.5"
                                           placeholder="name" />
                                </div>

                                <div class="relative w-full text-left">
                                    <label class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                                        <div>Description <span class="text-sm text-red-500" style="display: none;"> * </span></div>
                                    </label>
                                    <div class="flex flex-col mt-1">
                                    <textarea name="description" v-model="form.description" rows="2" class="box-border w-full px-3 py-2 text-sm
                                    not-italic font-normal leading-snug text-left text-black placeholder-gray-400
                                    bg-white border border-gray-200 border-solid rounded outline-none
                                    focus:ring-indigo-400 focus:border-indigo-400"
                                    placeholder="Description"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="py-6 px-4 bg-gray-50">
                            <div class="flex flex-col">
                                <base-btn ref="saveCategoryBtnRef" btn-label="Save Category" btn-icon="SaveIcon" btn-color="indigo"/>
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
    import categoryService from "@services/category-service.js";

    export default {
        name: 'slide-over-dialog-category',
        components: {
            BaseBtn,
            BaseHeroicon,
            TransitionRoot, TransitionChild, Dialog, DialogOverlay, DialogTitle, DialogDescription,
        },
        props: ['category_id'],
        data() {
            return {
                form: {
                    name: '',parent_id: 0, type: 1, description: ''
                },
                listOfCategories: [],
                isOpen: false,
                saveCategoryBtnRef: null
            };
        },
        methods: {
            async saveCategory() {
                categoryService.action(this.form, (results)=>{
                    this.isOpen = false;
                    const category = results.returnData;
                    this.$emit("refreshChildCategory", category)
                    this.form = {
                        name: '',parent_id: 0,  description: ''
                    }
                });
            },
            async searchChildCategories() {
                if (this.category_id){
                    const searchData = {
                            q: '',
                            'id': this.category_id,
                        };
                    const searchResultFn = (result)=>{
                        this.listOfCategories = result.returnData.list_of_items;
                        this.form.parent_id = this.listOfCategories[0].id;
                    };

                    categoryService.search(searchData, searchResultFn, true);
                }
            },
            setIsOpen(value, parentId = null, type) {
                console.log("Opening Slide Over Dialog Category");
                this.isOpen = value;
                if(parentId) {
                    this.form.parent_id = parentId;
                    this.form.type = type;
                    this.searchChildCategories();
                }
            }
        },
        created() {
            //this.searchChildCategories()
        }
    }
</script>

<style>
</style>
