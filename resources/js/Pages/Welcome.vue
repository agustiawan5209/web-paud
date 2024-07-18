<script setup>
import { Link, Head } from '@inertiajs/vue3';
import {
    FwbNavbar,
    FwbNavbarCollapse,
    FwbNavbarLink,
    FwbNavbarLogo,
    FwbCarousel,
    FwbCard,
} from 'flowbite-vue'
import { ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';

const pictures = [
    { src: '/images/bg-1.jpg', alt: 'Image 1' },
    { src: '/images/bg-2.jpg', alt: 'Image 2' },
    { src: '/images/bg-3.jpg', alt: 'Image 3' },
]

const open = ref(false)
</script>

<template>
    <Head title="Welcom"/>
    <GuestLayout>
        <fwb-carousel :pictures="pictures" slide :slide-interval="3000" />
        <hr>
        <div class="py-12">
            <div class="grid grid-cols-4 gap-7">
                <fwb-card v-for="item in 4" img-alt="Desk" img-src="https://flowbite.com/docs/images/blog/image-1.jpg" variant="image">
                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Noteworthy technology acquisitions 2021
                        </h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">
                            Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological
                            order.
                        </p>
                    </div>
                </fwb-card>
            </div>
        </div>
    </GuestLayout>
</template>
