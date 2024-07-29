<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,usePage } from '@inertiajs/vue3';
import HeaderStats from '@/Components/Header/HeaderStats.vue';
import { defineProps } from "vue";

const Page = usePage().props.auth;
const Roles = Page.role;
function roleToCheck(role) {
    if (Array.isArray(Roles)) {
        return Roles.includes(role)
    } else {
        return false;
    }
}
const props = defineProps({
    pengguna: {
        type: Number,
        default: 0,
    },
    siswa: {
        type: Number,
        default: 0,
    },
    kelas: {
        type: Number,
        default: 0,
    },
    orangtua: {
        type: Number,
        default: 0,
    },
    guru: {
        type: Number,
        default: 0,
    },

});
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-4 relative box-content">
            <div class="max-w-7xl mx-auto sm:px-6" v-if="roleToCheck('Admin') || roleToCheck('Guru')">
                <HeaderStats :pengguna="pengguna" :siswa="siswa" :guru="guru" :kelas="kelas" :orangtua="orangtua" />

            </div>
            <div class="py-4 relative box-content bg-white border rounded-lg" v-if="roleToCheck('Orang Tua')">
                <div class="bg-priamry overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="grid grid-cols-1 2xl:grid-cols-2 gap-7 p-2 place-content-end">
                        <div class=" p-3 flex justify-center items-center relative">
                            <div class="text-lg font-semibold text-center">
                                <span class="text-green-700 md:text-4xl">SISTEM INFORMASI MONITORING</span> <br>
                                <span class="md:text-2xl">PERKEMBANGAN PENDIDIKAN ANAK USIA DINI</span>
                                 BERBASIS WEB PADA <span class="text-red-600 text-2xl">PAUD INSAN MASAGENA
                                    MAKASSAR</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
