<script setup>
defineProps({
    alt: {
        type: String,
        default: 'Vertex International Academy',
    },
});
</script>

<template>
    <img
        src="/images/logo.png"
        :alt="alt"
        class="block h-full w-full shrink-0 rounded-full object-cover"
        draggable="false"
    />
</template>
