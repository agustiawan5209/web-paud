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
})
const crud = ref({
    tambah: true,
    edit: true,
    show: true,
    delete: true,

})

</script>

<template>

    <Head title="Siswa" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Data Siswa</h2>
        </template>

        <div class="py-4 relative box-content">
            <CardTable @update:search="search = $event" @update:order="order" :slug="null" path="Siswa" :TableData="data" :tableColums="table_colums" :crud="crud" />
        </div>
    </AuthenticatedLayout>
</template>
