import { createRouter, createWebHistory } from "vue-router";
import Home from "./components/pages/Home.vue";
import Login from "./components/auth/Login.vue";
import Registration from "./components/auth/Registration.vue";
import UserList from "./components/pages/UserList.vue";
import Dashboard from "./components/pages/Dashboard.vue";
import Sidebar from "./components/partials/Sidebar.vue";
import InventoryList from "./components/pages/InventoryList.vue";

const routes = [
    {
        path: '/',
        redirect: () => {
            const user = JSON.parse(localStorage.getItem('user'));
            return user ? '/dashboard' : '/login';
        },
    },
    {
        path: '/login',
        name: "Login",
        component: Login,
    },
    {
        path: '/registration',
        name: "Registration",
        component: Registration,
    },
    {
        path: '/', 
        component: Home,
        children: [
            {
                path: '/dashboard',
                components: {
                    default: Dashboard,
                    sidebar: Sidebar,
                },
            },
            {
                path: '/users',
                components: {
                    default: UserList,
                    sidebar: Sidebar,
                },
            },
            {
                path: '/inventories',
                components: {
                    default: InventoryList,
                    sidebar: Sidebar,
                },
            },
            {
                path: '/:pathMatch(.*)*',
                redirect: '/dashboard',
            }
        ],
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/login',
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;