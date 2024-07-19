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
import FormAnak from '@/Pages/Anak/Form.vue';
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
const Filter = dataSiswa.filter(function (param) {
    return !/id/g.test(param) && !/orang_tua/g.test(param)
})
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

function ObjectSliceKey() {
    if (props.siswa.riwayat_imunisasis.length > 0) {
        const parent = props.siswa.riwayat_imunisasis[0].data_imunisasi;

        return Object.keys(parent);
    } else {
        return {};
    }
}
const columsReplace = (element) => {

    return element.replace(/_|\b_id\b/g, ' ');
};


const ChartValue = ref(false)

</script>

<template>

    <Head title="Bayi/Siswa" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Form Show Bayi/Siswa</h2>
        </template>

        <div class="md:py-4 relative box-content">

            <section class=" py-2 px-0 md:px-6  md:py-6 bg-gray-100 text-gray-900">
                <PrimaryButton type="button" onclick="history.back();return false;">Kembali</PrimaryButton>

                <form novalidate="" action="" class="container flex flex-col mx-auto space-y-12">
                    <div class="space-y-2 col-span-full lg:col-span-1 px-3 md:px-0">
                        <p class="font-medium">Detail Informasi Bayi/Siswa</p>
                        <p class="text-xs">Detail data Bayi/Siswa dari puskesmas</p>
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
                                        <td class="text-sm border-b py-2 font-bold capitalize">Nomor Induk Kependudukan
                                            (NIK) -
                                            Bayi/Siswa</td>
                                        <td>:</td>
                                        <td class="text-sm border-b text-gray-600"> {{ siswa.nik }} </td>
                                    </tr>
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
                                        <td class="text-sm border-b py-2 font-bold capitalize">Usia</td>
                                        <td>:</td>
                                        <td class="text-sm border-b text-gray-600"> {{ siswa.hitung_usia }} </td>
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
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50"
                        v-if="siswa.riwayat_imunisasis.length > 0">
                        <PrimaryButton type="button" class="whitespace-nowrap col-span-full md:col-span-1"
                            @click="ChartValue = !ChartValue">Tampilkan Grafik Bayi/Siswa
                        </PrimaryButton>
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3" v-if="ChartValue">
                            <div class="col-span-full sm:col-span-3  border bg-white">
                                <ul class="flex flex-col space-y-20">
                                    <li class="flex gap-3 py-2 border-b">
                                        <span class="text-xs font-semibold pl-3">Pertumbuhan Berat Badan
                                            Bayi/Siswa</span>
                                    </li>
                                </ul>
                                <ChartBeratBadan :id="siswa.id" />
                            </div>
                            <div class="col-span-full sm:col-span-3  border bg-white">
                                <ul class="flex flex-col space-y-20">
                                    <li class="flex gap-3 py-2 border-b">
                                        <span class="text-xs font-semibold pl-3">Pertumbuhan Tinggi Badan
                                            Bayi/Siswa</span>
                                    </li>
                                </ul>
                                <ChartTinggiBadan :id="siswa.id" />
                            </div>
                            <div class="col-span-full sm:col-span-3  border bg-white">
                                <ul class="flex flex-col space-y-20">
                                    <li class="flex gap-3 py-2 border-b">
                                        <span class="text-xs font-semibold pl-3">Pertumbuhan Lingkar Kepala
                                            Bayi/Siswa</span>
                                    </li>
                                </ul>
                                <ChartLingkarKepala :id="siswa.id" />
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="grid grid-cols-3 gap-6 p-2 rounded-md shadow-sm bg-gray-50">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full overflow-x-auto ">
                                <ul class="flex flex-col space-y-20">
                                    <li class="flex gap-3 py-2 border-b">
                                        <span class="text-lg">Riwayat Imunisasi</span>
                                    </li>
                                </ul>

                                <table class="w-max table text-xs " v-if="siswa.riwayat_imunisasis.length > 0">

                                    <thead>
                                        <tr>
                                            <th class="border whitespace-nowrap">Tanggal Imunisasi</th>
                                            <th class="border whitespace-nowrap p-2"
                                                v-for="(item, key) in ObjectSliceKey()">{{
                                                    columsReplace(item) }}</th>
                                            <th class="border">Catatan Imunisasi</th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="(riwayat, key) in siswa.riwayat_imunisasis">
                                        <tr>
                                            <td class="whitespace-wrap border p-2">{{ parseDate(riwayat.tanggal) }}</td>
                                            <td class="whitespace-nowrap border p-2"
                                                v-for="(item, key) in riwayat.data_imunisasi">
                                                {{ item }}
                                            </td>
                                            <td class="text-xs px-1 border w-96 leading-4 tracking-wide"
                                                v-html="riwayat.catatan"></td>

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
