<script setup>
    import { defineProps } from 'vue';

    const props = defineProps({
        inventory: Object,
    });

    const excert = (text) => {
        return text.substring(0, 100) + '...';
    }

</script>

<template>
    <router-link :to="'/inventories/view/' + props.inventory.id" class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
        <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" src="../../assets/image-4.jpg" alt="">
        <div class="flex flex-col justify-between p-4 leading-normal">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ props.inventory.name.toString().toUpperCase() }}</h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                Owner Name: {{ props.inventory.user.name }}
            </p>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                {{ excert(props.inventory.description) }}
            </p>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                Total Products: {{ props.inventory.products.length }}
            </p>
        </div>
    </router-link>
</template>

<style scoped></style>
