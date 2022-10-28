<template>
    <TransitionRoot appear :show="isOpen" as="template">

        <Dialog
            :initialFocus="saveCommentBtnRef"
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
                        <DialogTitle class="text-xl font-bold">Comments</DialogTitle>
                        <button class="p-1 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="setIsOpen(false)">
                            <base-heroicon computed-icon="XIcon"/>
                        </button>
                    </div>

                    <div  class=" p-2">
                        <ul class="list-none">
                            <li class="p-1"  v-for="(comment, indexItem) in listOfComments" :key="indexItem" :class="(indexItem % 2 == 0) ? 'bg-white':'bg-gray-50'">
                                <strong>{{ comment.user.name }}:</strong> {{ comment.comment }}
                            </li>
                          </ul>
                    </div>

                    <form class="flex-1 flex flex-col" @submit.prevent="saveComment">

                        <div class="flex-1 relative">

                            <div class="absolute inset-0 overflow-y-scroll  py-1 px-1">
                                <div class="relative w-full group">
                                    <input type="text" id="name" v-model="form.comment" class="box-border text-black placeholder-gray-400
                                text-sm rounded-lg bg-white border border-gray-200 border-solid
                                rounded outline-none focus:ring-indigo-400 focus:border-indigo-400 block w-full p-2.5"
                                           placeholder="name" />
                                </div>
                            </div>
                        </div>
                        <div class="py-1 px-1 bg-gray-50">
                            <div class="flex flex-col">
                                <base-btn ref="saveCommentBtnRef" btn-label="Comment" btn-icon="SaveIcon" btn-color="indigo"/>
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
    import commentService from "@services/comment-service.js";
    import BaseSelectList from "../BaseSelectList";

    export default {
        name: 'slide-over-dialog-comment',
        components: {
            BaseSelectList,
            BaseBtn,
            BaseHeroicon,
            TransitionRoot, TransitionChild, Dialog, DialogOverlay, DialogTitle, DialogDescription,
        },
        data() {
            return {
                form: {
                    id: '', form_method: '', type: 1, comment: '',book_id: 0,  description: ''
                },
                listOfComments: [],
                isOpen: false,
                saveCommentBtnRef: null
            };
        },
        methods: {
            async searchComments() {
                await commentService.search({ book_id: this.form.book_id}, (result)=>{
                    this.listOfComments = result.returnData.list_of_items;
                });
            },
            async saveComment() {
                commentService.action(this.form, (results)=>{
                    this.isOpen = false;
                    this.$emit("refreshComment")
                    this.form = {
                        name: '',parent_id: 0,  description: ''
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
                        this.$emit("refreshComment");
                    });
                });
            },
            setIsOpen(value, id) {
                this.isOpen = value;
                this.form.book_id = id;
                this.searchComments()
            }
        },
        created() {}
    }
</script>

<style>
</style>
