import { createRouter, createWebHistory } from "vue-router";
import Login from "./components/auth/Login.vue";
import Registration from "./components/auth/Registration.vue";
import Sidebar from "./components/partials/Sidebar.vue";
import Home from "./components/pages/Home.vue";
import Dashboard from "./components/pages/Dashboard.vue";
import Inventory from "./components/pages/Inventory.vue";
import InventoryList from './components/inventories/InventoryList.vue';
import AddInventory from './components/inventories/AddInventory.vue'
import UpdateInventory from './components/inventories/UpdateInventory.vue'

import Users from "./components/pages/Users.vue";
import UserList from "./components/users/UserList.vue";
import UserDetail from "./components/users/UserDetail.vue";

import { ApiController } from './controllers/ApiController.js';

const auth = ApiController;

const routes = [
    {
        path: "/",
        redirect: () => {
            return auth.isAuthenticated ? "/dashboard" : "/login";
        },
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
    },
    {
        path: "/registration",
        name: "Registration",
        component: Registration,
    },
    {
        path: "/",
        component: Home,
        children: [
            {
                path: "/dashboard",
                components: {
                    default: Dashboard,
                    sidebar: Sidebar,
                },
            },
            {
                path: "/users",
                components: {
                    default: Users,
                    sidebar: Sidebar,
                },
                children: [
                    {
                        path: "",
                        component: UserList,
                    },
                    {
                        path: "create",
                        component: Registration,
                    },
                    {
                        path: ":id",
                        component: UserDetail,
                    },
                    {
                        path: ":id/edit",
                        component: Registration,
                    },
                ],
            },
            {
                path: "/inventories",
                components: {
                    default: Inventory,
                    sidebar: Sidebar,
                },
                children: [
                    {
                        path: "",
                        component: InventoryList,
                    },
                    {
                        path: "create",
                        component: AddInventory,
                    },
                    {
                        path: ":id",
                        component: UserDetail,
                    },
                    {
                        path: ":id/edit",
                        component: UpdateInventory,
                    },
                ]
            },
            {
                path: "/:pathMatch(.*)*",
                redirect: "/dashboard",
            },
        ],
    },
    {
        path: "/:pathMatch(.*)*",
        redirect: "/login",
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
