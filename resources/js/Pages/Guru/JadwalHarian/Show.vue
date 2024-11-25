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

const downloadPDF = () => {
    axios({
        method: 'get',
        url: route('Laporan.jadwal.cetak-harian', {
            slug: props.jadwal.id,
        }),
        responseType: 'blob'
    })
        .then(response => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', props.jadwal.tgl +'.pdf');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        })
        .catch(error => {
            console.log(error);
        });
};
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
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50 text-black">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full  ">
                                <ul class="flex flex-col space-y-20">
                                    <li class="flex gap-3 py-2 border-b">
                                        <span class="text-lg">Detail Informasi Jadwal Kegiatan
                                            {{ jadwal.nama_kelas }}</span>
                                    </li>
                                </ul>
                                <div class="p-2">
                                    <PrimaryButton @click="downloadPDF" class="!bg-red-600" type="button">
                                        <font-awesome-icon :icon="['fas', 'file-pdf']" />
                                        <span>cetak</span>
                                    </PrimaryButton>
                                </div>

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
                                        <td class="text-sm border-b text-gray-600"> {{ jadwal.tgl }}</td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold capitalize">penanggung jawab</td>
                                        <td>:</td>
                                        <td class="text-sm border-b text-gray-600"> {{ jadwal.penanggung_jawab }} </td>
                                    </tr>
                                </table>

                                <table class="w-full table">
                                    <tr class="bg-orange-200">
                                        <th class="text-sm border py-2 font-bold capitalize">Jam</th>
                                        <th class="text-sm border py-2 font-bold capitalize">Kegiatan</th>
                                        <th class="text-sm border py-2 font-bold capitalize">Pengembangan</th>
                                    </tr>

                                    <tr v-for="item in jadwal.jadwal">
                                        <td class="text-xs border p-2"> {{ item.jam }} </td>
                                        <td class="text-xs border p-2">{{ item.kegiatan }}</td>
                                        <td class="text-xs border p-2">{{ item.pengembangan }}</td>
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
