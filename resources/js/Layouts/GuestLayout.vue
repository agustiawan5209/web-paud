<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">
        <div class="max-w-screen-xl m-0 sm:m-10 bg-white shadow sm:rounded-lg flex justify-center flex-1">
            <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
                <div class="text-lg font-semibold text-center">
                    <span class="text-green-700 md:text-2xl">SISTEM INFORMASI MONITORING</span> <br>
                    <span class="md:text-xl">PERKEMBANGAN PENDIDIKAN ANAK USIA DINI</span>
                     BERBASIS WEB PADA <span class="text-red-600">PAUD INSAN MASAGENA
                        MAKASSAR</span>
                </div>
                <div class="mt-12 flex flex-col items-center">
                    <div class="w-full flex-1 mt-8">
                        <div class="mx-auto max-w-xs">
                            <slot/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1 bg-green-100 text-center hidden lg:flex">
                <div class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
                    style="background-image: url('svg/kids.svg');">
                </div>
            </div>
        </div>
    </div>
</template>
