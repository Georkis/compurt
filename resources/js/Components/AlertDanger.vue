<script setup>

</script>

<template>
    <div slot="danger" class="bg-red-700 text-white font-bold max-w-7xl mx-auto py-10 mt-2 rounded sm:px-6 lg:px-8">
        <div class="alert" :class="typeAlert">
            <slot />
        </div>
    </div>
</template>

<style scoped>

</style>
