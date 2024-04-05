<script setup>
    import { defineProps } from 'vue';

    const props = defineProps({
        user: Object,
    });
</script>

<template>
    <router-link :to="'/users/' + props.user.id" class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex p-5">
        <div class="flex-shrink-0">
            <img class="w-24 h-24 mb-0 rounded shadow-lg" src="../../assets/profile-picture-3.jpg" alt="" />
            <!-- <img class="w-24 h-24 mb-0 rounded shadow-lg" :src="props.user.profile_photo_path ? props.user.profile_photo_path : '../../assets/profile-picture-3.jpg'" :alt="props.user.name.toString().toLowerCase()" /> -->
        </div>
        
        <div class="flex flex-col justify-center ml-4">
            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ props.user.name }}</h5>
            <p class="mb-1 text-md font-medium text-gray-900 dark:text-white">
                {{ props.user.inventory.length }} Inventories
            </p>
            
            <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 text-center">{{ props.user.role.toString().toUpperCase() }}</span>
        </div>
    </router-link>
</template>

<style scoped></style>
