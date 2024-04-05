<script setup>
    import { useRoute } from 'vue-router'
    import { initFlowbite } from 'flowbite'
    import { onMounted, ref, onBeforeMount } from 'vue'
    import { ApiController } from '../../controllers/ApiController'
    import Product from './../products/Product.vue'
    import Alert from '../partials/Alert.vue'

    const auth = ApiController;
    const route = useRoute();
    const invName = ref("")
    const invDesc = ref("")
    const invProducts = ref([])
    const inventory = ref(null);

    onMounted(() => {
        initFlowbite();
    });

    onBeforeMount(() => {
        const res = auth.fetchProtectedApi(`/api/auth/inventories/view/${route.params.id}`, {}, 'GET');
        res.then((data) => {
            invDesc.value = data.inventory.description;
            invName.value = data.inventory.name;
            invProducts.value = data.inventory.products;
            inventory.value = data.inventory;
        }).catch((error) => {
            console.error("Error fetching inventory:", error);
        });
    });
    console.log("outside", inventory.value);
</script>

<template>
    <div class="p-4 sm:ml-0">
        <div class="bg-white shadow-md rounded-lg p-8">
            <div class="flex items-center mt-4">
                <div class="ml-4">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">{{ inventory.name }}</h2>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ inventory.description }}</h3>
                </div>
            </div>

            <div class="mt-4">
                <h3 class="block text-lg font-semibold text-gray-800 dark:text-white">Products</h3>
                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 mb-10">
                    <Alert message="No Inventories Found." type="info" v-if="inventory.products.length == 0" />
                    <Product v-for="item in inventory.products" :key="item.id" :inventory="item" :auth="auth" v-if="inventory.products.length != 0" />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
