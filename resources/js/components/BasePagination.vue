<template>
    <div class="flex justify-around">
        <div class="text-md text-gray-700">
            Showing <span class="font-semibold text-gray-900">{{pagination.from}}</span> to <span class="font-semibold text-gray-900">{{pagination.to}}</span> of <span class="font-semibold text-gray-900">{{pagination.total}}</span> Entries
        </div>
        <div>
            <nav aria-label="Page navigation example">
                <ul class="inline-flex items-center -space-x-px" v-if="pagination.last_page != 1">
                    <li v-if="pagination.current_page > 1">
                        <a href="#" @click.prevent="change(pagination.current_page -1)" class="block py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700">
                            <span class="sr-only">Previous</span>
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        </a>
                    </li>

                    <li v-for="page in pages" :key="page" >
                        <a @click.stop="change(page)" href="#" aria-current="page" :class="[page == pagination.current_page ? 'z-10 py-2 px-3 leading-tight text-blue-600 bg-blue-50 border border-blue-300 hover:bg-blue-100 hover:text-blue-700':'py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700']">
                            {{ page }}
                        </a>
                    </li>

                    <li v-if="pagination.current_page < pagination.last_page">
                        <a @click.prevent="change(pagination.current_page + 1)" href="#" class="block py-2 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700">
                            <span class="sr-only">Next</span>
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="text-md text-gray-700 flex p-1 ">
            <span class="p-0.5">Display </span>
            <select id="store_id" v-model="pagination.per_page" @change="change()"
                    class="box-border text-black placeholder-gray-400 text-md rounded-lg bg-white border border-gray-200
                    border-solid rounded outline-none focus:ring-indigo-400 focus:border-indigo-400 block w-fullring-1 p-0.5">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select> 
            <span class="p-0.5">Per Page</span>
        </div>
    </div>
        
    

</template>

<script>
    export default {
        props: {
            pagination: {
                type: Object,
                required: true
            },
            offset: {
                type: Number,
                default: 4
            },
        },
        computed: {
            pages() {
                if (!this.pagination.to) {
                    return null;
                }
                let from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                let to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                let pages = [];
                for (let page = from; page <= to; page++) {
                    pages.push(page);
                }
                return pages;
            },
        },
        methods: {
            change: function(page) {
                this.pagination.current_page = page;
                const current_page = page
                this.$emit('paginate',current_page,this.pagination.per_page);
            }
        }
    }
</script>