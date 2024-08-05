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
    nilai: {
        type: Object,
        default: () => ({})
    }
})
console.log(props.nilai)
</script>

<template>

    <Head title="Detail Nilai" />

    <AuthenticatedLayout>
        <template #header>
            <h2> Detail Nilai</h2>
        </template>

        <div class="md:py-4 relative box-content">
            <section class=" py-2 px-0 md:px-6  md:py-6 bg-primary text-dark">
                <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                    <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                        <div class="col-span-full  ">
                            <ul class="list-item space-y-2">
                                <li class="border-b">
                                    <span class="text-lg">Data Nilai Siswa </span>
                                </li>
                                <li class="border-b">
                                    <span class="text-lg">Kelas ={{ nilai.kelas.kode }}</span>
                                </li>
                                <li class="border-b">
                                    <span class="text-lg">Tanggal = {{ nilai.tanggal }}</span>
                                </li>
                                <li class="border-b">
                                    <span class="text-lg">Tahun Ajaran ={{ nilai.kelas.tahun_ajaran }}</span>
                                </li>
                                <li class="border-b">
                                    <span class="text-lg">Foto Siswa</span>
                                </li>
                            </ul>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 align-middle place-items-center py-4" >
                                <div class="col-span-1 bg-white border border-gray-200 rounded-lg shadow " v-for="item in nilai.galeri_nilai">
                                    <img class="rounded-t-lg object-cover " :src="item.image_path" alt="" />
                                </div>

                            </div>
                            <div class="relative overflow-x-auto border shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-2 py-3">
                                                No.
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Nama Siswa
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Kehadiran
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in nilai.datanilaisiswa" :key="item.id"
                                            class="odd:bg-white even:bg-gray-50 border-b">
                                            <td scope="row" class="px-2 py-4 border ">
                                                {{ index + 1 }}
                                            </td>
                                            <td class="px-6 py-4 border">
                                                {{ item.siswa.nama }}
                                            </td>
                                            <td class="px-6 py-4 border">
                                                <span>{{ item.nilai }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
