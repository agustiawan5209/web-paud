<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ChartJenisImunisasi from '@/Components/Chart/ChartJenisImunisasi.vue';
import SingleTable from '@/Components/Table/SingleTable.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

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
})
const crud = ref({
    tambah: props.can.add,
    edit: props.can.edit,
    show: false,
    delete: props.can.delete,
    reset_password: props.can.reset,

})

</script>

<template>

    <Head title="TahunAjar" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Data TahunAjar</h2>
        </template>

        <div class="py-4 relative box-content">
            <SingleTable @update:search="search = $event" @update:order="order" :slug="null" path="TahunAjar" :TableData="data" :tableColums="table_colums" :crud="crud" >

            </SingleTable>
        </div>
    </AuthenticatedLayout>
</template>
