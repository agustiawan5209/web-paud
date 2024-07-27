<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ChartJenisImunisasi from '@/Components/Chart/ChartJenisImunisasi.vue';
import SingleTable from '@/Components/Table/SingleTable.vue';
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
    edit: props.can.edit,
    show: props.can.show,
    delete: props.can.delete,
})

</script>

<template>

    <Head title="Kelas" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Data Kelas</h2>
        </template>

        <div class="py-4 relative box-content">
            <SingleTable @update:search="search = $event" @update:order="order" :relasi="relasi" :slug="null" path="Kelas" :TableData="data" :tableColums="table_colums" :crud="crud" />
        </div>
    </AuthenticatedLayout>
</template>
