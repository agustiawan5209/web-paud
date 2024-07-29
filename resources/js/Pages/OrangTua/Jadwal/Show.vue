<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import { ref, defineProps, watch, onMounted } from 'vue';

const page = usePage();
const props = defineProps({
    jadwal: {
        type: Object,
        default: () => ({})
    }
})

</script>

<template>

    <Head title="Jadwal Kegiatan" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Form Detail Jadwal Kegiatan</h2>
        </template>

        <div class="md:py-4 relative box-content">
           <section class=" py-2 px-0 md:px-6  md:py-6 bg-primary text-dark">
                <form novalidate="" action="" class="container flex flex-col mx-auto space-y-12">
                    <div class="space-y-2 col-span-full lg:col-span-1 px-3 md:px-0">
                        <p class="font-medium">Detail Informasi Jadwal Kegiatan Kelas {{jadwal.nama_kelas}}</p>
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
                                    <col class="w-32">
                                    <col class="w-3">
                                    <col>
                                    </colgroup>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold capitalize">Kelas</td>
                                        <td>:</td>
                                        <td class="text-sm border-b text-gray-600"> {{ jadwal.nama_kelas }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold capitalize">Tanggal</td>
                                        <td>:</td>
                                        <td class="text-sm border-b text-gray-600"> {{ jadwal.jadwal }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold capitalize">Nama Kegiatan</td>
                                        <td>:</td>
                                        <td class="text-sm border-b text-gray-600"> {{ jadwal.nama_kegiatan }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold capitalize">penanggung jawab</td>
                                        <td>:</td>
                                        <td class="text-sm border-b text-gray-600"> {{ jadwal.penanggung_jawab }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold capitalize">deskripsi</td>
                                        <td>:</td>
                                        <td class="text-sm border-b text-gray-600 text-left" v-html="jadwal.deskripsi"> </td>
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
