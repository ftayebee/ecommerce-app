<script setup>
import { useRoute } from 'vue-router'
import { initFlowbite } from 'flowbite'
import { onMounted, ref, onBeforeMount } from 'vue'
import InventoryCard from '../inventories/InventoryCard.vue'
import { ApiController } from '../../controllers/ApiController'
import Alert from '../partials/Alert.vue'

const auth = ApiController

onMounted(() => {
    initFlowbite();
})

const inventories = ref([]);

onBeforeMount(() => {
    const res = auth.fetchProtectedApi("/api/auth/inventories", {}, "GET");
    res.then((data) => {
        inventories.value = data.inventories;
    });
});
</script>

<template>
    <div class="p-4 sm:ml-64">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">All Inventories ({{inventories.length}})</h1>
        
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 mb-10">
            <Alert message="No Inventories Found." type="info" v-if="inventories.length == 0" />
            <InventoryCard v-for="item in inventories" :key="item.id" :inventory="item" v-if="inventories.length !== 0" />
        </div>
    </div>
    
</template>

<style scoped>
</style>
