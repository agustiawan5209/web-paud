<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
    icon:{
        type: Array,
        required: true,
    },
});

const classes = computed(() =>
    props.active
        ? 'relative flex items-center space-x-4 bg-gradient-to-r from-primary to-blue-400 p-2 mt-1 rounded-l text-base text-white'
        : ' flex items-center space-x-4 rounded-md p-2 mt-1 rounded-l text-base text-white'
);
const classesIcon = computed(() =>
    props.active ? 'text-blue-200' : 'text-gray-50 group-hover:text-blue-500'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <font-awesome-icon :icon="icon" :class="classesIcon"/>
        <slot />
    </Link>
</template>
