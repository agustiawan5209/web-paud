<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ChartJenisImunisasi from '@/Components/Chart/ChartJenisImunisasi.vue';
import CardTable from '@/Components/Table/CardTable.vue';
import Dropdown from '@/Components/Dropdown.vue';

import { ref, watch, defineProps } from 'vue';
const props = defineProps({
    search: {
        type: String,
        default: '',
    },
    order: {
        type: String,
        default: '',
    },
    data: {
        type: Object,
        default: () => ({}),
    },
    table_colums: {
        type: Object,
        default: () => ({}),
    },
    can: {
        type: Object,
        default: () => ({}),
    },
    relasi: {
        type: Object,
        default: () => ({}),
    },
})
const crud = ref({
    tambah: props.can.add,
    edit: false,
    show: props.can.show,
    delete: props.can.delete,
    absen: props.can.form,
})

</script>

<template>

    <Head title="Nilai Siswa" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Data Nilai Siswa</h2>
        </template>

        <div class="py-4 relative box-content">
            <CardTable @update:search="search = $event" @update:order="order" :slug="null" path="NilaiSiswa" :TableData="data" :tableColums="table_colums" :crud="crud" />
        </div>
    </AuthenticatedLayout>
</template>
