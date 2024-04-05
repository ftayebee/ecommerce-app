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
    const res = auth.fetchProtectedApi("/api/auth/inventories", { isAdmin: auth.user.role == 'user' }, "GET");
    res.then((data) => {
        inventories.value = data.inventories;
    });
});
</script>

<template>
    <div class="p-4 sm:ml-64">
        <router-view></router-view>
    </div>
</template>

<style scoped>
</style>
