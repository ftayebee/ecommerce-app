<script setup>
import { useRoute } from 'vue-router'
import { initFlowbite } from 'flowbite'
import { onMounted, ref } from 'vue'
import UserList from './../users/UserList.vue'
import Inventory from './../pages/Inventory.vue'

onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <div class="p-4 sm:ml-64">
        <UserList />
        <Inventory />
    </div>
</template>

<style scoped>
</style>
