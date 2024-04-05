<script setup>
    import { defineProps } from 'vue';
    import { useRoute } from 'vue-router';
    import { ApiController } from '../../controllers/ApiController'
    import { inventoryController } from '../../controllers/InventoryController.js'

    const route = useRoute();
    const auth = ApiController

    const props = defineProps({
        inventory: Object,
        auth: Object,
    });

    const excert = (text) => {
        return text.substring(0, 60) + '...';
    }
</script>

<template>
    <router-link :to="'/inventories/view/' + props.inventory.id"
        class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
        <div class="flex flex-col justify-between p-10 leading-normal">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ props.inventory.name.toString().toUpperCase() }}</h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400" v-if="!route.path.includes('/users/')">
                Owner Name: {{ props.inventory.user.name }}
            </p>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                {{ excert(props.inventory.description) }}
            </p>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400" v-if="!route.path.includes('/users/')">
                Total Products: {{ props.inventory.products.length }}
            </p>
            <div class="flex flex-row justify-start items-center">
                <button type="button" @click="inventoryController.deleteInventory(props.inventory.id)" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    Delete
                </button>
                <router-link :to="'inventories/' + props.inventory.id + '/edit'" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Edit</router-link>
            </div>
        </div>
    </router-link>
</template>

<style scoped></style>
