<template>
    <li class="relative group">
        <button @click="toggleDropdown" :class="classes">
            <span class="mr-3">
                <slot name="icon"></slot>
            </span> {{ title }}
            <svg :class="{ 'rotate-180': isOpen }"
                class="w-4 h-4 ml-auto transition-transform transform group-hover:rotate-180"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <ul v-show="isOpen" class="pl-8 transition-all">
            <slot></slot>
        </ul>
    </li>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    active: {
        type: Boolean,
    },
});

const isOpen = ref(false);

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
};

const classes = computed(() =>
    props.active
        ? 'flex items-center w-full p-4 hover:bg-gray-700 bg-gradient-to-r from-primary to-green-400 '
        : 'flex items-center w-full p-4 hover:bg-gray-700'
);
</script>

<style scoped>
.rotate-180 {
    transform: rotate(180deg);
}
</style>
