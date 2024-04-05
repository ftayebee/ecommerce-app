<script setup>
    import { useRoute } from 'vue-router'
    import { initFlowbite } from 'flowbite'
    import { onMounted, ref, onBeforeMount } from 'vue'
    import { ApiController } from '../../controllers/ApiController'
    import Alert from '../partials/Alert.vue'
    import InventoryCard from '../inventories/InventoryCard.vue'

    const auth = ApiController;
    const route = useRoute();
    const user = ref(null);

    onMounted(() => {
        initFlowbite();
    });

    onBeforeMount(() => {
        const res = auth.fetchProtectedApi(`/api/auth/users/${route.params.id}`, {}, 'GET');
        res.then((data) => {
            user.value = data.user;
        });
    });

</script>

<template>
    <!-- tailwind user profile page -->
    <div class="p-4 sm:ml-0">
        <div class="bg-white shadow-md rounded-lg p-8" v-if="user !== null">
            <div class="flex items-center mt-4">
                <img class="w-24 h-24 rounded-full shadow-lg" src="../../assets/profile-picture-3.jpg" alt="" />
                <div class="ml-4">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">{{ user.name }}</h2>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ user.email }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ user.phone }}</p>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 text-center w-auto">{{ user.role.toString().toUpperCase() }}</span>
                </div>
            </div>

            <div class="mt-4">
                <h3 class="block text-lg font-semibold text-gray-800 dark:text-white">Inventories</h3>
                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 mb-10">
                    <Alert message="No Inventories Found." type="info" v-if="user.inventory.length == 0" />
                    <InventoryCard v-for="item in user.inventory" :key="item.id" :inventory="item" :auth="auth" v-if="user.inventory.length != 0" />
                </div>
            </div>
        </div>
        <p v-else>
            Loading...
        </p>
    </div>
    <!-- <div class="p-4 sm:ml-64">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">{{ user.name }}</h2>
                <span
                    class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 text-center w-auto">{{
            user.role.toString().toUpperCase() }}</span>
            </div>
    <!--        <div class="flex items-center mt-4">
                <img class="w-24 h-24 rounded-full shadow-lg" src="../../assets/profile-picture-3.jpg" alt="" />
                <img class="w-24 h-24 rounded-full shadow-lg" :src="user.profile_photo_path ? user.profile_photo_path : '../../assets/profile-picture-3.jpg'" :alt="user.name.toString().toLowerCase()" />
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ user.email }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ user.phone }}</p>
                </div>
            </div>
        </div>
    </div> -->
</template>

<style scoped></style>
