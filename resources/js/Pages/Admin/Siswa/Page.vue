<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import ChartJenisImunisasi from '@/Components/Chart/ChartJenisImunisasi.vue';
import CardTable from '@/Components/Table/CardTable.vue';
import Dropdown from '@/Components/Dropdown.vue';
import {
    FwbSpinner,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
} from 'flowbite-vue'
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
            <div class="flex flex-col w-full">
                <div class="-m-1.5">
                    <div class="p-1.5 min-w-full">
                        <div
                            class="border divide-y divide-gray-200 max-w-7xl mb-8 overflow-hidden rounded-lg shadow-xs bg-white">

                            <div class="w-full overflow-x-auto">
                                <fwb-table hoverable striped class="w-full table-full overflow-x-auto">

                                    <fwb-table-head
                                        class="text-xs md:text-base font-semibold tracking-wide text-left uppercase border-b border-gray-700  ">
                                        <fwb-table-head-cell scope="col"
                                            class="px-2 py-1 md:px-6 md:py-3 text-nowrap text-start font-medium capitalize bg-green-600 text-white">
                                            No.
                                        </fwb-table-head-cell>
                                        <fwb-table-head-cell scope="col"
                                            class="px-2 py-1 md:px-6 md:py-3 text-nowrap text-start font-medium capitalize bg-green-600 text-white">
                                            Nama Kelas
                                        </fwb-table-head-cell>
                                        <fwb-table-head-cell
                                            class=" px-2 py-1 md:px-3 md:py-3 text-center font-medium uppercase bg-green-600 text-white">Detail
                                        </fwb-table-head-cell>
                                    </fwb-table-head>
                                    <fwb-table-body class="bg-white divide-y ">
                                        <fwb-table-row v-for="(item, index) in data.data" :key="item.id"
                                            class="text-gray-700 dark:text-gray-400">

                                            <fwb-table-cell
                                                class="px-2 py-1 md:px-4 md:py-3  text-xs font-medium text-gray-800 border">
                                                {{ (data.current_page - 1) * data.per_page + index + 1 }}

                                            </fwb-table-cell>
                                            <fwb-table-cell
                                                class="px-2 py-1 md:px-4 md:py-3  text-xs font-medium text-gray-800 border">
                                                {{ item.kode }}

                                            </fwb-table-cell>

                                            <fwb-table-cell
                                                class="px-2 py-1 md:px-4 md:py-3  text-xs font-medium text-gray-800 border relative">
                                                <Link
                                                    :href="route('Siswa.index', { slug: item.id })"
                                                    class="flex justify-start gap-3 text-gray-700 cursor-pointer">
                                                    <font-awesome-icon class="text-blue-500 hover:text-blue-700"
                                                        :icon="['fas', 'eye']" />
                                                    Detail
                                                </Link>
                                            </fwb-table-cell>
                                        </fwb-table-row>

                                    </fwb-table-body>
                                </fwb-table>
                            </div>
                            <div class="py-1 px-4 ">
                                <div class="flex flex-wrap">
                                    <template v-for="(link, key) in data.links">
                                        <div v-if="link.url === null" :key="key"
                                            class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                            v-html="link.label" />
                                        <Link v-else :key="`link-${key}`"
                                            class="mb-1 mr-1 px-4 py-3 focus:text-indigo-500 text-sm leading-4 active:border-blue-400 hover:bg-gray-200 border focus:border-indigo-500 rounded"
                                            :class="{ 'bg-white border-blue-500 text-black': link.active }"
                                            preserve-state preserve-scroll :data="{ search, slug, order }"
                                            :href="link.url" v-html="link.label" />
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
