<template>
    <console-layout>
        <div class="flex flex-wrap justify-between">
            <base-console-breadcrumb-sub-item  showBreadcrumb="true" link-return-title="Items" link-return-title-uri="item-list" title="Book Form" linkTitle="Book Form" />
        </div>

        <div>
            <div class="flex flex-col pt-5">
                <form @submit.prevent="saveItem">
                    <div class="bg-white rounded-lg shadow w-full">
                        <div class="px-4 py-5 sm:px-8 sm:py-8">
                            <div class="grid gap-y-6 gap-x-4 grid-cols-1">
                                <div class="grid xl:grid-cols-2 xl:gap-6">
                                    <input type="hidden" v-model="form.id"  name="id" id="id"/>
                                    <input type="hidden" v-model="form.form_method" name="form_method" id="form_method"/>

                                    <div class="relative w-full group">
                                        <label for="name" class="block mb-2 text-sm font-medium text-gray-800" >Name</label>
                                        <input type="text" id="name" v-model="form.name" class="box-border text-black placeholder-gray-400 text-sm rounded-lg bg-white border border-gray-200 border-solid rounded outline-none focus:ring-indigo-400 focus:border-indigo-400 block w-full p-2.5" placeholder="Name of the book" />
                                    </div>
                                    <div class="relative w-full group">
                                        <label for="author" class="block mb-2 text-sm font-medium text-gray-800">Author</label>
                                        <input type="text" id="author" v-model="form.author" class="box-border text-black placeholder-gray-400 text-sm rounded-lg bg-white border border-gray-200 border-solid rounded outline-none focus:ring-indigo-400 focus:border-indigo-400 block w-full p-2.5" placeholder="Author" />
                                    </div>

                                    <div class="relative w-full group">
                                        <label  for="year_published"  class="block mb-2 text-sm font-medium text-gray-800" >Year Published</label>
                                        <input type="year" id="year_published" v-model="form.year_published"  class="box-border text-black placeholder-gray-400 text-sm rounded-lg bg-white border border-gray-200 border-solid rounded outline-none focus:ring-indigo-400 focus:border-indigo-400 block w-full p-2.5"  placeholder="Year Published" />
                                    </div>
                                </div>

                                <div>
                                    <base-btn btn-label="Save Book" btn-icon="SaveIcon" btn-color="indigo"  />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </console-layout>
</template>

<script>
import ConsoleLayout from "@layout/ConsoleLayout";
import BaseConsoleBreadcrumbSubItem from "@components/breadcrumb/BaseConsoleBreadcrumbSubItem";
import BaseBtn from "@components/BaseBtn";
import uiService from "@services/ui-service.js";
import itemService from "@services/item-service.js";
import BaseBtnIconOnly from "@components/BaseBtnIconOnly";
import BaseSelectList from "@components/BaseSelectList";
import CategoryType from "@models/enums/category-type";

export default {
    name: "book-form",
    components: {
        BaseSelectList,
        BaseBtnIconOnly,
        BaseConsoleBreadcrumbSubItem,
        BaseBtn,
        ConsoleLayout,
    },
    data() {
        return {
            form: {
                id: "",  form_method: "save", name: "",  author: "",  year_published: ''
            },
            listOfCategories: [],
            listOfChildCategories: [],
            isOpen: false,
        };
    },
    async created() {
        const id = this.$route.params.id;
        if (id) {
            await itemService.get({ id: id }, (results) => {
                this.form = results.returnData.item;
                this.form.form_method = "update";
            });
        }
    },
    methods: {
        async saveItem() {
            itemService.action(this.form, (results) => {
                uiService.showSuccess("Success", results.errorMessage, () => {
                    this.$router.push({ name: "item-list" });
                });
            });
        },
    },
};
</script>

<style></style>
