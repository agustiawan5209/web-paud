<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';

import { ref, defineProps, watch, onMounted } from 'vue';
import ChartBeratBadan from '@/Components/Chart/ChartBeratBadan.vue';
import ChartTinggiBadan from '@/Components/Chart/ChartTinggiBadan.vue';
import ChartLingkarKepala from '@/Components/Chart/ChartLingkarKepala.vue';
import axios from 'axios';

const page = usePage();
const props = defineProps({
    siswa: {
        type: Object,
        default: () => ({})
    }
})

const dataSiswa = Object.keys(props.siswa)


</script>

<template>

    <Head title="Siswa" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Form Show Siswa</h2>
        </template>

        <div class="md:py-4 relative box-content">

           <section class=" py-2 px-0 md:px-6  md:py-6 bg-primary text-dark">
                <PrimaryButton type="button" onclick="history.back();return false;">Kembali</PrimaryButton>

                <form novalidate="" action="" class="container flex flex-col mx-auto space-y-12">
                    <div class="space-y-2 col-span-full lg:col-span-1 px-3 md:px-0">
                        <p class="font-medium">Detail Informasi Siswa</p>
                        <p class="text-xs">Detail data Siswa dari </p>
                    </div>
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full  ">
                                <ul class="flex flex-col space-y-20">
                                    <li class="flex gap-3 py-2 border-b">
                                        <span class="text-lg">Detail</span>
                                    </li>
                                </ul>

                                <table class="w-full table">
                                    <colgroup>
                                        <col>
                                        <col class="w-3">
                                        <col>
                                    </colgroup>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold capitalize">Nama</td>
                                        <td>:</td>
                                        <td class="text-sm border-b text-gray-600"> {{ siswa.nama }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold capitalize">Tempat Lahir</td>
                                        <td>:</td>
                                        <td class="text-sm border-b text-gray-600"> {{ siswa.tempat_lahir }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold capitalize">Tanggal Lahir</td>
                                        <td>:</td>
                                        <td class="text-sm border-b text-gray-600"> {{ siswa.tgl_lahir }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold capitalize">Jenis Kelamin</td>
                                        <td>:</td>
                                        <td class="text-sm border-b text-gray-600"> {{ siswa.jenkel }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold capitalize">Nama Orang Tua</td>
                                        <td>:</td>
                                        <td class="text-sm border-b text-gray-600"> {{ siswa.nama_orang_tua }} </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
