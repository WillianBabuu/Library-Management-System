import { createRouter, createWebHistory } from "vue-router";
import Web from "@views/web.vue";

import ItemList from "@views/console/item/list.vue";
import ItemForm from "@views/console/item/form.vue";

import UserList from "@views/console/user/list.vue";
import UserForm from "@views/console/user/form.vue";
import Login from "@views/auth/login.vue";
import Signup from "@views/auth/signup.vue";
import CurrentUserStore from "@store/current-user.js";

const routes = [
    { path: "/", redirect: "/web" },
    { path: "/web", name: "web", component: Web, meta: { isProtected: false } },

    //auth pages
    { path: "/login", name: "login", component: Login, meta: { isProtected: false }, },
    { path: "/signup", name: "signup", component: Signup, meta: { isProtected: false }, },

    { path: "/item-list", name: "item-list", component: ItemList, meta: { isProtected: true }, },
    { path: "/item-form/:id?", name: "item-form", component: ItemForm, meta: { isProtected: true }, },

  
    { path: "/user-list", name: "user-list", component: UserList, meta: { isProtected: true },},
    { path: "/user-form/:id?", name: "user-form", component: UserForm, meta: { isProtected: true },},

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.isProtected && !CurrentUserStore.state.user.token) {
        next({ name: "login" });
    } else if (to.name === "login" && CurrentUserStore.state.user.token) {
        next({ name: "item-list" });
    }
    /*else if (CurrentUserStore.state.user.token && to.meta.isGuest) {
           next({ name: 'Dashboard' })
       }*/
    else {
        next();
    }
});

export default router;