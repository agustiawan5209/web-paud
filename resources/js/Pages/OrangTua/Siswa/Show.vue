<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import { ref, defineProps, watch, onMounted } from 'vue';

const page = usePage();
const props = defineProps({
    siswa: {
        type: Object,
        default: () => ({})
    }
})

const dataSiswa = Object.keys(props.siswa)
function parseDate(tgl) {
    const today = new Date(tgl);

    const options = {
        weekday: 'long',  // full weekday name (Senin, Selasa, etc.)
        year: 'numeric',  // numeric year (2024)
        month: 'long',    // full month name (April)
        day: 'numeric',   // numeric day (22)
    };

    const formatter = new Intl.DateTimeFormat('id-ID', options);
    const formattedDate = formatter.format(today);
    return formattedDate;
}


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
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full  ">
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
                    <fieldset class="grid grid-cols-3 gap-6 p-2 rounded-md shadow-sm bg-gray-50">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full overflow-x-auto ">
                                <ul class="flex flex-col space-y-20">
                                    <li class="flex gap-3 py-2 border-b">
                                        <span class="text-lg">Perkembangan Siswa</span>
                                    </li>
                                </ul>

                                <table class="w-full table text-xs " v-if="siswa.dataperkembangansiswa.length > 0">
                                    <colgroup>
                                    <col class="w-48">
                                    <col>
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th class="border whitespace-nowrap">Tanggal</th>
                                            <th class="border">Laporan Perkembangan</th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="(item, key) in siswa.dataperkembangansiswa">
                                        <tr>
                                            <td class="whitespace-wrap text-center border p-2">{{ item.perkembangansiswa.tanggal }}</td>

                                            <td class="text-xs px-1 border w-96 leading-4 tracking-wide"
                                                v-html="item.perkembangan"></td>

                                        </tr>

                                    </tbody>
                                </table>
                                <table class="w-full table text-xs text-center" v-else>

                                    <thead>
                                        <tr>
                                            <th class="border whitespace-nowrap text-center p-3">Data Riwayat Imunisasi
                                                Masih
                                                Kosong</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
