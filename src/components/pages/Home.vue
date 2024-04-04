<script setup>
    import { useRoute } from 'vue-router'
    import { initFlowbite } from 'flowbite'
    import { onMounted, ref, onBeforeMount } from 'vue'
    import Sidebar from '../partials/Sidebar.vue'

    onMounted(() => {
        initFlowbite();
    })
</script>

<template>
    <aside id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
        <Sidebar />
    </aside>

    <router-view></router-view>
</template>

<style scoped>
    #sbar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 200px;
        /* Adjust the width as needed */
        background-color: white;
        z-index: 1000;
        /* Adjust the z-index as needed */
    }

    .content {
        margin-left: 200px;
        /* Adjust the margin to accommodate the sidebar width */
    }
</style>
