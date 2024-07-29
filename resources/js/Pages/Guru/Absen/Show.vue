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
    absen: {
        type: Object,
        default: () => ({})
    }
})

</script>

<template>

    <Head title="Detail Absensi" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Detail Absensi</h2>
        </template>

        <div class="md:py-4 relative box-content">
           <section class=" py-2 px-0 md:px-6  md:py-6 bg-primary text-dark">
                <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                    <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                        <div class="col-span-full  ">
                            <ul class="list-item space-y-2">
                                <li class="border-b">
                                    <span class="text-lg">Data Absensi </span>
                                </li>
                                <li class="border-b">
                                    <span class="text-lg">Kelas ={{ absen.kelas.kode }}</span>
                                </li>
                                <li class="border-b">
                                    <span class="text-lg">Tanggal = {{ absen.tanggal }}</span>
                                </li>
                                <li class="border-b">
                                    <span class="text-lg">Tahun Ajaran ={{ absen.kelas.tahun_ajaran }}</span>
                                </li>
                            </ul>

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
                                        <tr v-for="(item, index) in absen.dataabsensi" :key="item.id"
                                            class="odd:bg-white even:bg-gray-50 border-b">
                                            <td scope="row" class="px-2 py-4 border ">
                                                {{ index + 1 }}
                                            </td>
                                            <td class="px-6 py-4 border">
                                                {{ item.siswa.nama }}
                                            </td>
                                            <td class="px-6 py-4 border">
                                                <span>{{ item.absen }}</span>
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
