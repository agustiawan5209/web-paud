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

</script>

<template>

    <Head title="Laporan Perkembangan Harian" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Laporan Perkembangan Harian Siswa {{siswa.nama}}</h2>
        </template>

        <div class="md:py-4 relative box-content">

           <section class=" py-2 px-0 md:px-6  md:py-6 bg-primary text-dark">
                <PrimaryButton type="button" onclick="history.back();return false;">Kembali</PrimaryButton>

                <div class="relative overflow-x-auto border shadow-md sm:rounded-lg mt-5">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <colgroup>
                        <col class="w-10">
                        <col class="w-60">
                        <col>
                        </colgroup>
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-2 py-3 border">
                                    No.
                                </th>
                                <th scope="col" class="px-6 py-3 border">
                                    Tanggal Laporan Harian
                                </th>
                                <th scope="col" class="px-6 py-3 border">
                                    Nilai
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in siswa.dataperkembangansiswa" :key="item.id"
                                class="odd:bg-white even:bg-gray-50 border-b">
                                <td scope="row" class="px-2 py-4 border ">
                                    {{ index + 1 }}
                                </td>
                                <td class="px-6 py-4 border">
                                    <span> {{ item.perkembangansiswa.tanggal }} </span>
                                </td>
                                <td class="px-6 py-4 border" v-html="item.perkembangan">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
