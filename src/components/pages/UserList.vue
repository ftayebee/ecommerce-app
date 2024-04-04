<script setup>
import { useRoute } from 'vue-router'
import { initFlowbite } from 'flowbite'
import { onMounted, ref, onBeforeMount } from 'vue'
import UserCard from '../users/UserCard.vue'
import { ApiController } from '../../controllers/ApiController'

const auth = ApiController

onMounted(() => {
    initFlowbite();
})

const users = ref([]);

onBeforeMount(() => {
    // const res = auth.fetchProtectedApi("/api/auth/users", {}, "GET");
    // res.then((data) => {
    //     users.value = data.users;
    // });
});

</script>

<template>
    <div class="p-4 sm:ml-64">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">All Users ({{users.length}})</h1>
        
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-10">
            <UserCard v-for="user in users" :key="user.id" :user="user"/>
        </div>
    </div>
    
</template>

<style scoped>
</style>
