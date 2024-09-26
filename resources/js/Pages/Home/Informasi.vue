<script setup>
import { Head, Link } from '@inertiajs/vue3';
import HomeLayout from '@/Layouts/HomeLayout.vue'

import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, defineProps } from 'vue'
const props = defineProps({
    informasi: {
        type: Object,
        default: () => ({}),
    },
})

</script>

<template>

    <Head title="Tentang Kami PAUD INSAN MASAGENA" />
    <HomeLayout>

        <div class="container mx-auto overflow-hidden md:px-6 2xl:px-0 xl:max-w-7xl relative" v-if="informasi !== null">
            <section class="p-6 dark:bg-gray-100 dark:text-gray-800">
                <div class="container flex flex-col-reverse sm:flex-row gap-6 mx-auto text-center ">
                    <div class="w-full px-6 py-16 rounded-md sm:px-12 md:px-16 dark:bg-gray-50">
                        <h1 class="text-5xl font-extrabold dark:text-gray-900">{{ informasi.kepala_informasi }}</h1>
                        <h1 class="text-lg font-extrabold dark:text-gray-900">Kepala PAUD {{informasi.nama_informasi}}</h1>
                        <p class="my-8 text-justify" v-html="informasi.deskripsi">

                        </p>
                    </div>
                    <div class="w-full ">
                        <svg class=" h-max w-full rounded-full object-contain text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                            v-if="informasi.foto_profile == null">
                            <path fill-rule="evenodd"
                                d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <img v-else :src="informasi.profile_url" alt=""
                            class="object-contain rounded-full w-full h-max " />
                    </div>
                </div>
            </section>
            <section>
                <div class="bg-primary">
                    <div class="container flex flex-col items-center px-4 py-16 pb-24 mx-auto text-center lg:pb-56 md:py-32 md:px-10 lg:px-32 text-white">
                        <h1 class="text-5xl font-bold leading-none sm:text-6xl xl:max-w-3xl ">Visi</h1>
                        <p class="mt-6 text-lg sm:mb-12 xl:max-w-3xl " v-html="informasi.visi"></p>
                    </div>
                </div>
                <div class="bg-white w-5/6 mx-auto mb-12 -mt-20 rounded-lg shadow-md lg:-mt-40">
                    <h1 class="text-5xl font-bold leading-none sm:text-6xl w-full text-center ">Misi</h1>

                    <p class="p-7 space-y-10 text-justify" v-html="informasi.misi"></p>
                </div>
            </section>
        </div>
        <div class="container mx-auto overflow-hidden md:px-6 2xl:px-0 xl:max-w-7xl relative" v-else>

            <section>
                <div class="bg-primary">
                    <div class="container flex flex-col items-center px-4 py-16 pb-24 mx-auto text-center lg:pb-56 md:py-32 md:px-10 lg:px-32 text-white">
                        <h1 class="text-5xl font-bold leading-none sm:text-6xl xl:max-w-3xl ">Data Tampilan Informasi Masih Kosong</h1>
                    </div>
                </div>
            </section>
        </div>
    </HomeLayout>
</template>


<style >
/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.fade-enter-active {
    transition: all 0.3s ease-out;
}

.fade-leave-active {
    transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.fade-enter-from {
    transform: translateX(-100%);
    opacity: 0;
}

.fade-leave-to {
    transform: translateX(100%);
    opacity: 0;
}

section ul *,section ol *{
    margin: 10px 0px;
}
section ul li, section ol li{
    list-style: decimal;
}
</style>
