<template>
    <default-layout>
        <div class="flex min-h-screen overflow-hidden">
            <div class="relative flex-1 hidden w-0 overflow-hidden lg:block">
                <img class="absolute inset-0 object-cover w-full h-full bg-black" src="https://images.unsplash.com/photo-1510915228340-29c85a43dcfe?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="">
            </div>
            <div class=" flex flex-col justify-center flex-1 px-4 py-12 overflow-hidden sm:px-6 lg:flex-none lg:px-20 xl:px-24">
                <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 lg:w-96">
                    <div class="max-w-md w-full space-y-8">
                        <div>
                            <router-link to="/" class="flex justify-center items-center text-black font-extrabold">
                                <img class="h-12 w-auto inline" src="/images/logo.png" alt="Vendbox" /> VENDBOX
                            </router-link>
                            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">LOGIN</h2>
                            <p class="mt-2 text-center text-sm text-gray-600">
                                Or
                                <router-link :to="{ name: 'signup' }" class="font-medium text-indigo-600 hover:text-indigo-500"> sign up </router-link>
                            </p>
                        </div>
                        <form class="mt-8 space-y-6" @submit.prevent="loginAction">
                            <input type="hidden" name="remember" value="true" />
                            <div class="rounded-md shadow-sm -space-y-px">
                                <div>
                                    <label for="email-address" class="sr-only">Email address</label>
                                    <input id="email-address" v-model="credentials.email" name="email" type="email" autocomplete="email" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address" />
                                </div>
                                <div>
                                    <label for="password" class="sr-only">Password</label>
                                    <input id="password" v-model="credentials.password" name="password" type="password" autocomplete="current-password" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password" />
                                </div>
                            </div>

                            <div>
                                <button type="submit"
                                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent
                                text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                  <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
                                </span>
                                    Sign in
                                </button>
                            </div>
                        </form>

                        <!--<div class="relative my-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 text-neutral-600 bg-white"> Or continue with </span>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </default-layout>
</template>

<script>
    import DefaultLayout from "@layout/DefaultLayout";
    import { LockClosedIcon } from '@heroicons/vue/solid'
    import uiService from '@services/ui-service.js';
    import authService from '@services/auth-service.js';

    export default {
        name: 'login',
        components: {
            DefaultLayout,
            LockClosedIcon,
        },
        data() {
            return {
                credentials: {
                    email: '',
                    password: '',
                    remember: false,
                    device_name: 'browser',
                },
                errors: { },
            }
        },
        methods: {
            async loginAction(){
                await authService.login(this.credentials, (results)=>{
                    uiService.showSuccess('Success!', results.errorMessage, ()=>{
                        this.$store.commit('currentUser/USER_LOGIN', results.returnData);
                        this.$router.push({ name: 'item-list'});
                    });
                });
            },
        }
    }
</script>

<style>
</style>
