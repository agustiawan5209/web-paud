<script setup>
import { defineProps, ref } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps(['jasa'])
</script>

<template>
    <div class="bg-gray-800 pt-20 " id="pricing">
        <div class="relative mx-auto max-w-7xl px-6 text-center lg:px-8 mb-10">
            <div class="mx-auto max-w-2xl lg:max-w-4xl">
                <h2 class="text-lg font-semibold leading-8 text-teal-400">Harga</h2>
                <p class="mt-2 text-4xl font-bold tracking-tight text-gray-200 capitalize">penyewaan paket jasa pementasan tari </p>
            </div>
        </div>
        <div class="">
            <div class="relative z-10 mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto grid max-w-md grid-cols-1 gap-8 lg:max-w-7xl lg:grid-cols-3 lg:gap-8">
                    <div v-for="item in jasa" class="flex flex-col rounded-3xl  bg-gray-900 shadow-xl ring-1 ring-black/10">
                        <div class="p-8 sm:p-10">
                            <div class="flex">
                                <h3 class="text-lg font-semibold leading-8 tracking-tight text-teal-400"
                                    id="tier-basic">{{item.nama}}</h3>
                                <div class="items-center ml-2"></div>
                            </div>
                            <div
                                class="mt-4 flex items-baseline text-5xl tracking-tight text-gray-200 font-semibold">
                                {{ item.rupiah }}
                                <span
                                    class="text-lg font-semibold leading-8 tracking-normal text-gray-400"></span>
                            </div>
                            <!-- <p class="mt-6 text-base leading-7 text-gray-300">Great for getting
                                started. Sign your first two documents
                                for free.</p> -->
                        </div>
                        <div class="flex flex-1 flex-col p-2">
                            <div
                                class="flex flex-1 flex-col justify-between rounded-2xl bg-gray-700 p-6 sm:p-8">
                                <p v-html="item.keterangan" class="text-white"></p>
                                <div class="mt-8"><Link :href="route('payment.checkout', {slug: item.id})"
                                        class="inline-block w-full rounded-lg bg-teal-600 px-4 py-2.5 text-center text-sm font-semibold leading-5 text-white shadow-md hover:bg-teal-500 cursor-pointer"
                                        aria-describedby="tier-basic">Mulai Penyewaan</Link></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
