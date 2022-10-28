<template>
    <console-layout>
        <div class="flex flex-wrap justify-between">
            <base-console-breadcrumb showBreadcrumb="true" title='Books' linkTitle='Books'/>
            <base-btn-container>
                <base-btn btn-color="indigo" btn-label="Add Book" btn-icon="PlusIcon" @click="goToAddItem"/>
            </base-btn-container>
        </div>

        <div>
            <div class="flex flex-col pt-5">
                <base-table-wrap>
                    <base-table>
                        <thead class="bg-gray-50">
                        <tr>
                            <base-table-header>Name</base-table-header>
                            <base-table-header>Author</base-table-header>
                            <base-table-header>Year</base-table-header>
                            <base-table-header>
                            <span v-if="popular">
                                <BaseBtnOutlineIconOnly title="Favourite" btnIcon="ArrowDownIcon" btnColor="green" @click="sortByFavourite();" />
                            </span>
                            <span v-else>
                                <BaseBtnOutlineIconOnly title="Favourite" btnIcon="ArrowUpIcon" @click="sortByFavourite();" />
                            </span>
                                Likes
                            </base-table-header>
                            <base-table-header>Favourite</base-table-header>
                            <base-table-header-end>Action</base-table-header-end>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(book, indexItem) in listOfItem" :key="indexItem" :class="(indexItem % 2 == 0) ? 'bg-white':'bg-gray-50'">
                                <base-table-data>{{ book.name }}</base-table-data>
                                <base-table-data>
                                    {{ book.author }}
                                </base-table-data>
                                <base-table-data>
                                    {{ book.year_published }}
                                </base-table-data>
                                <base-table-data>
                                    <span v-if="book.user_like.length">
                                        <BaseBtnOutlineIconOnly title="Like" btnColor="red" btnIcon="HeartIcon"  @click="likeBook(book.id);" />
                                    </span>
                                    <span v-else>
                                        <BaseBtnOutlineIconOnly title="Like" btnIcon="HeartIcon"  @click="likeBook(book.id);" />
                                    </span>
                                    <span>
                                        {{ book.likes_count }} likes
                                    </span>

                                </base-table-data>
                                <base-table-data>
                                    <span v-if="book.favourite.length">
                                        <BaseBtnOutlineIconOnly title="Favourite" btnIcon="StarIcon" btnColor="green" @click="favouriteBook(book.id);" />
                                    </span>
                                    <span v-else>
                                        <BaseBtnOutlineIconOnly title="Favourite" btnIcon="StarIcon" @click="favouriteBook(book.id);" />
                                    </span>

                                </base-table-data>
                                <base-table-data :class="'text-right'">

                                    <base-drop-down :list-of-book="[
                                        { icon : 'PencilIcon',  description : 'Edit', okFunction: ()=>{ goToEditBook(book.id); }, disabled: false, },
                                        { icon : 'TrashIcon',  description : 'Delete', okFunction: ()=>{ deleteBooks(book.id); }, disabled: false, },
                                    ]">
                                        <base-heroicon computed-icon="DotsHorizontalIcon"/>
                                    </base-drop-down>

                                </base-table-data>

                            </tr>
                        </tbody>
                    </base-table>
                        <BasePagination :pagination="allPaginationData" @paginate="searchItem" :page="paginate" />
                </base-table-wrap>
            </div>
        </div>
    </console-layout>
</template>

<script>
    import BaseBtnOutlineIconOnly from "@components/BaseBtnOutlineIconOnly"
    import ConsoleLayout from "@layout/ConsoleLayout";
    import BaseConsoleBreadcrumb from "@components/breadcrumb/BaseConsoleBreadcrumb";
    import BaseBtnContainer from "@components/BaseBtnContainer";
    import BaseBtn from "@components/BaseBtn";
    import BaseTableNoResultsFound from "@components/BaseTableNoResultsFound";
    import BaseTable from "@components/table/BaseTable";
    import BaseTableWrap from "@components/table/BaseTableWrap";
    import BaseTableHeader from "@components/table/BaseTableHeader";
    import BaseTableData from "@components/table/BaseTableData";
    import BaseTableHeaderEnd from "@components/table/BaseTableHeaderEnd";
    import BaseHeroicon from "@components/BaseHeroicon";
    import BaseDropDown from "@components/BaseDropDown";
    import uiService from "@services/ui-service.js";
    import itemService from "@services/item-service.js";
    import BasePagination from "@components/BasePagination.vue";

    export default {
        name: 'item-list',
        components: {
    BaseHeroicon,
    BaseDropDown,
    BaseTableHeaderEnd,
    BaseTableData,
    BaseTableHeader,
    BaseTableWrap,
    BaseTable,
    BaseBtn,
    BaseBtnContainer,
    BaseConsoleBreadcrumb,
    BaseTableNoResultsFound,
    ConsoleLayout,
    BasePagination,BaseBtnOutlineIconOnly
},
        data() {
            return {
                listOfItem: [],
                allPaginationData:[],
                paginate: 10,
                current_page: 1,
                form: {
                    id : ''
                },
                popular: false,
            }
        },
        async created() {
            // console.log('About to get Book List');
            await this.searchItem();
        },
        methods: {
            async sortByFavourite(){
                this.popular = !this.popular
                this.searchItem()
            },
            async searchItem(current_page = 1, paginate = 10) {
                this.current_page = current_page;
                if (paginate) {
                    this.paginate = paginate
                }
                await itemService.search({ paginate: paginate, current_page: current_page, popular: this.popular}, (result)=>{
                    this.allPaginationData = result.returnData.list_of_items;
                    this.listOfItem = result.returnData.list_of_items.data;
                });
            },
            async likeBook(id){
                this.form.id = id;
                await itemService.like(this.form, (results) => {
                    this.form.id = [];
                    this.searchItem()
                });
            },
            async favouriteBook(id){
                this.form.id = id;
                await itemService.favourite(this.form, (results) => {
                    this.form.id = [];
                    this.searchItem()
                });
            },
            async goToAddItem(){
                this.$router.push({ name: 'item-form' });
            },
            async goToEditBook(id){
                this.$router.push({ name: 'item-form', params: { id:id } });
            },
            async deleteBook(id){
                uiService.confirmDelete(()=>{
                    itemService.delete(id, (results)=>{
                        uiService.showSuccess('Deleted!', results.errorMessage);
                        this.$forceUpdate();
                        this.searchItem()
                    });
                });
            },
        },
    }
</script>

<style>
</style>
