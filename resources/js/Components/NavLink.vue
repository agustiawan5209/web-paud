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
        ? 'relative flex items-center space-x-4 rounded-xl bg-gradient-to-r from-primary to-green-400 px-4 py-3 text-white'
        : 'group flex items-center space-x-4 rounded-md px-4 py-3 text-gray-600'
);
const classesIcon = computed(() =>
    props.active ? 'text-green-200' : 'text-gray-500 group-hover:text-green-500'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <font-awesome-icon :icon="icon" :class="classesIcon"/>
        <slot />
    </Link>
</template>
