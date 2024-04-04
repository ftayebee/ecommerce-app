<script setup>
import { useRoute } from 'vue-router'
import { initFlowbite } from 'flowbite'
import { onMounted, ref } from 'vue'
import UserList from '../pages/UserList.vue'
import InventoryList from '../pages/InventoryList.vue'

onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <UserList />

    <InventoryList />

    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">All Products (999)</h1>
</template>

<style scoped>
</style>
