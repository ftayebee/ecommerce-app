<script setup>
import { useRoute } from 'vue-router'
import { initFlowbite } from 'flowbite'
import { onMounted, ref, onBeforeMount } from 'vue'
import InventoryCard from '../inventories/InventoryCard.vue'
import { ApiController } from '../../controllers/ApiController'
import Alert from '../partials/Alert.vue'
import { inventoryController } from '../../controllers/InventoryController.js'

const auth = ApiController

onMounted(() => {
    initFlowbite();
})

const inventories = ref([]);

onBeforeMount(() => {
    // const endpoint = auth.user.role == 'user' ? 
    const res = auth.fetchProtectedApi("/api/auth/inventories", { isAdmin: auth.user.role == 'user' }, "GET");
    res.then((data) => {
        inventories.value = data.inventories;
    });
});
</script>

<template>
    <div class="flex flex-row justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">All Inventories ({{inventories.length}})</h1>

        <router-link to="/inventories/create" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
            <i class="pi pi-user-plus"></i> Add New Inventory
        </router-link>
    </div>
    
    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 mb-10">
        <Alert message="No Inventories Found." type="info" v-if="inventories.length == 0" />
        <InventoryCard v-for="item in inventories" :key="item.id" :inventory="item" v-if="inventories.length !== 0" />
    </div>    
</template>

<style scoped>
</style>
