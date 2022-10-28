<template>
    <Listbox v-model="selectedItem">
        <div class="relative mt-1 w-full">
            <ListboxButton
                class="relative w-full py-2 pl-3 pr-10 text-left bg-white rounded-md cursor-default
                focus:outline-none focus-visible:ring-2 focus-visible:ring-opacity-75 focus-visible:ring-white
                focus-visible:ring-offset-orange-300 focus-visible:ring-offset-2 focus-visible:border-indigo-500
                border border-gray-200 border-solid outline-none focus:ring-indigo-400 focus:border-indigo-400
                sm:text-sm">
                <span class="block truncate">{{ selectedItem[keyDescription] }}</span>
                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <base-heroicon computed-icon="SelectorIcon" :class="'text-gray-400'"/>
                </span>
            </ListboxButton>

            <transition
                leave-active-class="transition duration-100 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0">

                <ListboxOptions
                    class="absolute w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-60
                    ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm z-10" >
                    <ListboxOption
                        v-slot="{ active, selected }" v-for="item in listOfItem"
                        :key="item[keyValue]" :value="item" as="template">
                        <li
                            :class="[
                                active ? 'text-indigo-900 bg-indigo-100' : 'text-gray-900',
                                'cursor-default select-none relative py-2 pl-10 pr-4',
                            ]">
                            <span
                                :class="[
                                    item[keyValue] === selectedItem[keyValue] ? 'font-medium' : 'font-normal',
                                    'block truncate',
                                ]" >{{ item[keyDescription] }}</span>
                            <span
                                v-if="item[keyValue] === selectedItem[keyValue]"
                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-indigo-600">
                                <base-heroicon computed-icon="CheckIcon" />
                            </span>
                        </li>
                    </ListboxOption>
                </ListboxOptions>

            </transition>
        </div>
    </Listbox>
</template>

<script>
    import { ref } from 'vue';
    import { Listbox, ListboxLabel, ListboxButton, ListboxOptions, ListboxOption, } from '@headlessui/vue';
    import BaseHeroicon from "@components/BaseHeroicon";

    export default {
        name: 'base-select-list',
        components: {
            BaseHeroicon,
            Listbox, ListboxLabel, ListboxButton, ListboxOptions, ListboxOption,
        },
        data(){
            return {
                selectedItem: ref(null),
            }
        },
        props: {
            defaultSelection: String,
            keyValue: String,
            keyDescription: String,
            selectedItemId: String,
            listOfItem: {
                require: true,
                type: Array,
            }
        },
        created() {
            if(this.defaultSelection){
                let defaultSelection = {};
                defaultSelection[this.keyValue] = '';
                defaultSelection[this.keyDescription] = this.defaultSelection;
                this.selectedItem = defaultSelection;
                if(this.listOfItem && !this.listOfItem.some(e => e[this.keyValue] === defaultSelection[this.keyValue])) {
                    this.listOfItem.unshift(defaultSelection);
                }
            }
            let selectedItem = (this.listOfItem) ? this.listOfItem.filter((item)=>{
                return item[this.keyValue] === this.selectedItemId;
            }) : null;
            if(selectedItem && selectedItem.length > 0) { this.selectedItem = selectedItem[0]; }
        },
        computed: {
            listOfItem: {
                get() {
                    if(this.defaultSelection){
                        let defaultSelection = {};
                        defaultSelection[this.keyValue] = '';
                        defaultSelection[this.keyDescription] = this.defaultSelection;
                        this.selectedItem = defaultSelection;
                        if(!this.listOfItem.some(e => e[this.keyValue] === defaultSelection[this.keyValue])) {
                            this.listOfItem.unshift(defaultSelection);
                        }
                    }
                    return this.listOfItem;
                }
            }
        }
    }
</script>

<style>
</style>
