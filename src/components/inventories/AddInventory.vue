<script setup>
    import { useRoute } from 'vue-router'
    import { initFlowbite } from 'flowbite'
    import { onMounted, ref, onBeforeMount } from 'vue'
    import InventoryCard from '../inventories/InventoryCard.vue'
    import { ApiController } from '../../controllers/ApiController'
    import Alert from '../partials/Alert.vue'

    const auth = ApiController

    const route = useRoute()

    onMounted(() => {
        initFlowbite();
    })

    const invName = ref("")
    const invDesc = ref("")

</script>

<template>
    <div class="p-8 sm:ml-0">
        <div class="bg-white shadow-md rounded-lg p-8">
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Add New Inventory Informations</h1>
            <form action="#" class="mt-3" @submit.prevent="inventoryController.saveInventory({name: invName.value, description: invDesc.value }, `/api/auth/inventories/store`)">
                <div class="m-3">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Inventory
                        Name</label>
                    <input v-model="invName" type="text" name="name" id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                        placeholder="INVENTORY NAME" required>
                </div>
                <div class="m-3">
                    <label for="email"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <textarea v-model="invDesc" name="description" id="description"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="Inventory Description" required cols="2" rows="3"></textarea>
                </div>
                <div class="mt-4 text-center">
                    <button type="submit" class="w-1/4 m-auto text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-primary-800">Save</button>
                </div>
            </form>
            <div class="flex items-center mt-4">
            </div>
        </div>
    </div>
</template>

<style scoped></style>
