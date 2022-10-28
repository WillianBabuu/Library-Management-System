<template>
    <default-layout>
        <div class="flex min-h-screen overflow-hidden">
            <div class=" flex flex-col justify-center flex-1 px-4 py-12 overflow-hidden sm:px-6 lg:flex-none lg:px-20 xl:px-24">
                <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 lg:w-96">
                    <div class="max-w-md w-full space-y-8">
                        <div>
                            <router-link to="/" class="flex justify-center items-center text-black font-extrabold">
                                <img class="h-12 w-auto inline" src="/images/logo.png" alt="Vendbox" /> VENDBOX
                            </router-link>
                            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">UPDATE PASSWORD</h2>
                            <p class="mt-2 text-center text-sm text-gray-600">
                                Or
                                <router-link :to="{ name: 'login' }" class="font-medium text-indigo-600 hover:text-indigo-500"> login </router-link>
                            </p>
                        </div>
                        <form class="mt-8 space-y-6" @submit.prevent="registerAccount">
                            <input type="hidden" name="remember" value="true" />
                            <div class="rounded-md shadow-sm -space-y-px">
                                
                                <div v-if="emailSent">
                                    <div>
                                        <label for="password" class="sr-only">Password</label>
                                        <input id="password" v-model="form.password" type="password"
                                            class="appearance-none rounded-none relative block w-full px-3 py-2 border
                                    placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500
                                    focus:border-indigo-500 focus:z-10 sm:text-sm"
                                        :class="errors.password ? 'border-red-500' : 'border-gray-300'"   placeholder="Password" />
                                        <p class="text-red-500 text-xs italic"  v-if="errors.password">{{ errors.password[0] }}</p>
                                    </div>
                                    <div>
                                        <label for="password_confirmation" class="sr-only"> Confirm Password</label>
                                        <input id="password_confirmation" v-model="form.password_confirmation" type="password"
                                            class="appearance-none rounded-none relative block w-full px-3 py-2 border
                                    placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500
                                    focus:border-indigo-500 focus:z-10 sm:text-sm"
                                        :class="errors.password_confirmation ? 'border-red-500' : 'border-gray-300'"    placeholder="Confirm Password" />
                                        <p class="text-red-500 text-xs italic"  v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</p>
                                    </div>
                                </div>
                                <div v-else>
                                    <label for="email-address" class="sr-only">Email address</label>
                                    <input id="email-address" v-model="form.email" type="email"
                                           class="appearance-none rounded-none relative block w-full px-3 py-2 border
                                   placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500
                                   focus:border-indigo-500 focus:z-10 sm:text-sm"
                                    :class="errors.email ? 'border-red-500' : 'border-gray-300'"   placeholder="Email address" />
                                    <p class="text-red-500 text-xs italic"  v-if="errors.email">{{ errors.email[0] }}</p>
                                </div>

                            </div>

                            <div>
                                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
                                    </span>
                                    Sign in
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="relative flex-1 hidden w-0 overflow-hidden lg:block">
                <img class="absolute inset-0 object-cover w-full h-full bg-black" src="https://images.unsplash.com/photo-1510915228340-29c85a43dcfe?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="">
            </div>
        </div>
    </default-layout>
</template>

<script>
    import DefaultLayout from "@layout/DefaultLayout";
    import { LockClosedIcon } from '@heroicons/vue/solid';
    import uiService from '@services/ui-service.js';
    import authService from '@services/auth-service.js';

    export default {
        name: 'login',
        components: {
            DefaultLayout,
            LockClosedIcon,
        },
        data(){
            return{
                form:{
                    email: '',
                    password: '',
                    password_confirmation: '',
                },
                emailSent: false,
                errors: false,
            }
        },
        methods: {
            async registerAccount(){
                await authService.register(this.form, (results)=>{
                    uiService.showSuccess('Success!', results.errorMessage, ()=>{
                        this.$store.commit('currentUser/USER_LOGIN', results.returnData);
                        this.$router.push({ name: 'company-register'});
                    });
                });
            }
        },
    }
</script>

<style>
</style>
