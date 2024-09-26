<script setup>
import { Head, Link } from '@inertiajs/vue3';
import HomeLayout from '@/Layouts/HomeLayout.vue'

import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, defineProps } from 'vue'
const props = defineProps({
    kajian_hari_ini: {
        type: Object,
        default: () => ({}),
    },
    kajian_bulan_ini: {
        type: Object,
        default: () => ({}),
    },
    jadwal: {
        type: Object,
        default: () => ({}),
    },
})

const Vkajian = ref('today');
const activeClass = 'bg-success text-white font-bold rounded-[44px]';
const NonactiveClass = 'text-gray-400';
</script>

<template>
    <Head title="Jadwal Imunisasi" />
    <HomeLayout>

        <div class="container mx-auto overflow-hidden md:px-6 2xl:px-0 xl:max-w-7xl relative">
            <img :src="'/images/svg/Segmentation-bro.svg'" class="fixed top-0 w-1/2 object-contain opacity-25 -z-20" />
            <div class="flex flex-col gap-6 md:gap-12 pb-16 pt-6 z-50">
                <div>
                    <div class="flex flex-col lg:items-center pt-1 md:pt-16 gap-6 mb-1 md:mb-3">
                        <h1 class="text-[28px] text-center md:text-4xl font-medium leading-[51px] md:leading-[58px] text-gray-900">
                           Jadwal Imunisasi UPT Puskesmas Karassing
                        </h1>
                        <div class="w-full sm:w-96 border-2 border-blue-600"></div>
                    </div>
                </div>
                <transition  name="fade">
                    <main class="flex lg:gap-22"  >
                        <div class="flex flex-col justify-between gap-8 w-full h-full" v-if="jadwal.length > 0">
                            <table class="w-full text-xs text-left text-gray-500 bg-white">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">No.</th>
                                        <th scope="col" class="px-4 py-3">Tanggal</th>
                                        <th scope="col" class="px-4 py-3">usia</th>
                                        <th scope="col" class="px-4 py-3">jenis imunisasi</th>
                                        <th scope="col" class="px-4 py-3">Ket</th>
                                        <th scope="col" class="px-4 py-3">tempat</th>
                                        <th scope="col" class="px-4 py-3">Penanggung Jawab</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,index) in jadwal" class="border-b ">
                                        <th class="border text-center">{{ index+1 }}.</th>


                                        <th scope="row"
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap text-start ">
                                            {{ item.tanggal }}</th>
                                        <td class="px-4 py-3">{{ item.usia }}</td>
                                        <td class="px-4 py-3">{{ item.jenis_imunisasi }}</td>
                                        <td class="px-4 py-3">
                                            <p v-html="item.deskripsi"></p>
                                        </td>
                                        <td class="px-4 py-3">{{ item.tempat }}</td>
                                        <td class="px-4 py-3">{{ item.penanggung_jawab }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex flex-col justify-between gap-8 w-full h-full" v-else>
                            <div class="w-full h-96">
                                <div class="w-full h-full flex flex-col justify-center items-center gap-8">
                                    <div class="flex justify-center items-center w-32 h-32 bg-gray-100 rounded-full">
                                        <img src="/icons/empty-activities.svg" alt="Ikon agenda kosong" width="56" height="69">
                                    </div>
                                    <div class="flex flex-col justify-center items-center">
                                        <h2 class="text-blue-800 font-bold leading-6 text-center">
                                            Tidak ada jadwal di hari ini
                                        </h2>
                                        <p class="text-gray-500 text-sm font-light leading-6 text-center">
                                            Silakan lihat agenda akan datang atau lihat jadwal lainnya.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </transition>
            </div>
        </div>
    </HomeLayout>
</template>


<style>
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
</style>
