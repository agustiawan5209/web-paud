<script setup>

import { Head, useForm, Link, usePage } from '@inertiajs/vue3';
import { ref, watch, defineProps, inject, defineExpose, onMounted } from 'vue';
import dropdownTable from '@/Components/dropdownTable.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import axios from 'axios';
const swal = inject('$swal')


const order = ref('')
const search = ref('')

defineExpose({
    search,
    order
})
const page = usePage()

onMounted(() => {
    if (page.props.message !== null) {
        swal({
            icon: "success",
            title: 'Berhasil',
            text: page.props.message,
            showConfirmButton: true,
            timer: 2000
        });
    }
})

const props = defineProps({
    links: Array,
    slug: {
        type: String,
        default: '',
    },
    path: {
        type: String,
        default: '',
    },
    type: {
        type: String,
        default: '',
    },
    TableData: {
        type: Object,
        default: () => ({}),
    },
    tableColums: {
        type: Object,
        default: () => ({}),
    },
    crud: {
        type: Object,
        default: () => ({}),
    },
    datereport: {
        type: Object,
        default: () => ({}),
    },

})

const Form = useForm({
    search: search,
    order: order,
})

watch(search, (value) => {
    Form.search = value;
    Form.get(route(props.path + '.index'), {
        preserveState: true,
        preserveScroll: true,
    })
    // ColumData.value = ref(props.TableData.data);
})
watch(order, (value) => {
    Form.order = value;
    Form.get(route(props.path + '.index', {}), {
        preserveState: true,
        preserveScroll: true,
    })
    // ColumData.value = ref(props.TableData.data);
})

const columsReplace = props.tableColums.map(element => {
    if (element == 'org_tua_id') {
        return 'Orang Tua'
    } else {
        return element.replace(/_|\b_id\b/g, ' ');
    }
});


// Modal Delete
const VarDeleteModal = ref(false);
const DeleteForm = useForm({
    slug: null,
    title: null,
})

function showDeleteModal(item) {

    DeleteForm.slug = item.id;
    DeleteForm.title = item.nama ?? item.name;
    VarDeleteModal.value = true;
}

function deleteItem() {
    DeleteForm.delete(route(props.path + '.destroy'), {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            VarDeleteModal.value = false;
            DeleteForm.reset('slug');
            swal({
                icon: "success",
                title: 'Berhasil',
                text: page.props.message,
                showConfirmButton: true,
                timer: 2000
            });
        }
    })
}

function cekAksi() {
    if (props.crud.tambah || props.crud.edit || props.crud.show || props.crud.delete) {
        return true;
    } else {
        return false;
    }
}


function truncateText(col) {
    console.log(col == null)
    if (col == '' || col == null) {
        return '';
    } else {
        var paragraphs = col
        var text = '';
        var paragraph = ''
        for (var i = 0; i < paragraphs.length; i++) {
            if (i < 100) {
                text += paragraphs[i]
            }
        }
        text += '........'
        return text;
    }
}
const FormLaporan = useForm({
    start_date: props.datereport.start_date,
    end_date: props.datereport.end_date,
    type: props.type,
})

function searchDate() {
    FormLaporan.get(route(props.path + '.' + props.type), {
        preserveState: true,
        preserveScroll: true,
    })
}
const downloadPDF = () => {
    axios({
        method: 'get',
        url: route(props.path + '.cetak',{
            start_date: FormLaporan.start_date,
            end_date: FormLaporan.end_date,
            type: props.type,
        }),
        responseType: 'blob'
    })
        .then(response => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'penyewaan.pdf');
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
    <Modal :show="VarDeleteModal">
        <div id="alert-additional-content-4"
            class="p-4 text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800"
            role="alert">
            <div class="flex items-center">
                <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <h3 class="text-lg font-medium">Apakah anda yakin ingin menghapus {{ DeleteForm.title }}</h3>
            </div>
            <div class="mt-2 mb-4 text-sm">
                Mengklik iya akan menyebabkan data terhapus permanen
            </div>
            <div class="flex">
                <button type="button" @click="VarDeleteModal = false"
                    class="text-white bg-yellow-800 hover:bg-yellow-900 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center dark:bg-yellow-300 dark:text-gray-800 dark:hover:bg-yellow-400 dark:focus:ring-yellow-800">
                    <svg class="me-2 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 14">
                        <path
                            d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                    </svg>
                    Tidak
                </button>
                <button type="button" @click="deleteItem()"
                    class="text-yellow-800 bg-transparent border border-yellow-800 hover:bg-yellow-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-yellow-300 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-gray-800 dark:focus:ring-yellow-800"
                    data-dismiss-target="#alert-additional-content-4" aria-label="Close">
                    Ya
                </button>
            </div>
        </div>
    </Modal>
    <div class="flex flex-col w-full">
        <div class="-m-1.5">
            <div class="p-1.5 min-w-full">
                <div
                    class="border divide-y divide-gray-200 max-w-7xl mb-8 overflow-hidden rounded-lg shadow-xs bg-white">
                    <div class="py-3 px-4" v-if="crud.tambah">
                        <div class="relative max-w-xs">
                            <Link :href="route(props.path + '.create')">
                            <PrimaryButton type="button">Tambah Data</PrimaryButton>
                            </Link>
                        </div>
                    </div>
                    <div class="py-3 px-4 flex justify-between">
                        <div class="flex gap-3 items-center">
                            <div class="relative max-w-xs flex items-center">
                                <label class="whitespace-nowrap">Tangal Mulai</label>
                                <input type="date" name="hs-table-with-pagination-search"
                                    id="hs-table-with-pagination-search" v-model="FormLaporan.start_date"
                                    class="py-1 md:py-2 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                            </div>
                            <div class="relative max-w-xs flex items-center">
                                <label class="whitespace-nowrap">Tanggal Akhir</label>
                                <input type="date" name="hs-table-with-pagination-search"
                                    id="hs-table-with-pagination-search" v-model="FormLaporan.end_date"
                                    class="py-1 md:py-2 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                            </div>
                            <div class="relative flex">
                                <PrimaryButton type="button" @click="searchDate">
                                    <font-awesome-icon :icon="['fas', 'search']" class="mr-2" />
                                    <span>Cari Data</span>
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                    <div class="p-2" v-show="TableData.data.length > 0">
                        <PrimaryButton @click="downloadPDF" class="!bg-red-600" type="button">
                            <font-awesome-icon :icon="['fas', 'file-pdf']" />
                            <span>cetak</span>
                        </PrimaryButton>
                    </div>
                    <div class="w-full overflow-x-auto">
                        <table class="w-full table overflow-x-auto">
                            <colgroup>
                                <template v-for="(item, index) in columsReplace">
                                    <col v-if="index == 0" class="w-10">
                                    <col v-else>
                                </template>
                                <col>
                            </colgroup>
                            <thead class="bg-blue-900">
                                <tr
                                    class="text-xs md:text-sm font-semibold tracking-wide text-left uppercase border-b border-gray-700  text-white ">
                                    <th scope="col" v-for="item in columsReplace"
                                        class="px-2 py-1 md:px-6 md:py-3 text-nowrap text-start font-medium capitalize">
                                        <span v-if="item == 'id' || item == 'slug'" class="w-10">
                                            No.
                                        </span>
                                        <span v-else>{{ item }}</span>
                                    </th>
                                    <th scope="col" v-if="cekAksi()"
                                        class=" px-2 py-1 md:px-3 md:py-3 text-center font-medium uppercase">Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y " v-if="TableData.data.length > 0">
                                <tr v-for="(item, index) in TableData.data" :key="item.id"
                                    class="text-gray-700 dark:text-gray-400"
                                    :class="{ 'opacity-75 blur-sm': Form.processing }">
                                    <td class="px-2 py-1 md:px-4 md:py-3  text-xs font-medium text-gray-800 border"
                                        v-for="col in tableColums">

                                        <span v-if="col == 'id' || col == 'slug'">
                                            {{ (TableData.current_page - 1) * TableData.per_page + index + 1 }}
                                        </span>
                                        <span v-else-if="col == 'deskripsi' || col == 'keterangan'">
                                            <p v-html="truncateText(item[col])"></p>
                                        </span>
                                        <span v-else-if="col == 'customer_id'">
                                            <ul>
                                                <li>{{ item.customer.nama }}</li>
                                                <li v-if="item.customer.user != null">{{ item.customer.user.phone }}
                                                </li>
                                            </ul>
                                        </span>
                                        <span v-else-if="col == 'status'">
                                            <span v-if="item.status == 'PENDING'"
                                                class="inline-flex items-center justify-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-yellow-700">

                                                <p class="whitespace-nowrap text-xs">{{ item.status }}</p>
                                            </span>
                                            <span v-else-if="item.status == 'DIBATALKAN'"
                                                class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700">

                                                <p class="whitespace-nowrap text-xs">{{ item.status }}</p>
                                            </span>
                                            <span v-else
                                                class="inline-flex items-center justify-center rounded-full bg-blue-100 px-2.5 py-0.5 text-blue-700">

                                                <p class="whitespace-nowrap text-xs">{{ item.status }}</p>
                                            </span>
                                        </span>
                                        <span v-else :class="col == 'tanggal' ? 'whitespace-nowrap' : ''">{{ item[col]
                                            }}</span>
                                    </td>
                                    <td class="px-2 py-1 md:px-4 md:py-3  text-xs font-medium text-gray-800 border relative"
                                        v-if="cekAksi()">
                                        <!-- Settings dropdownTable -->
                                        <div class="ml-3 relative z-50">
                                            <dropdownTable align="top" width="48">
                                                <template #trigger>
                                                    <span class="inline-flex rounded-md">
                                                        <button type="button"
                                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                            Aksi

                                                            <font-awesome-icon :icon="['fas', 'ellipsis-vertical']"
                                                                class="ml-2 -mr-0.5 h-4 w-4" />

                                                        </button>
                                                    </span>
                                                </template>

                                                <template #content>
                                                    <DropdownLink v-if="crud.edit"
                                                        :href="route(props.path + '.edit', { slug: item.id })"
                                                        class="flex justify-start gap-3 text-gray-700">
                                                        <font-awesome-icon class="text-blue-500 hover:text-blue-700"
                                                            :icon="['fas', 'pen-to-square']" />
                                                        Edit
                                                    </DropdownLink>
                                                    <DropdownLink v-if="crud.show"
                                                        :href="route(props.path + '.show', { slug: item.id })"
                                                        class="flex justify-start gap-3 text-gray-700">
                                                        <font-awesome-icon class="text-blue-500 hover:text-blue-700"
                                                            :icon="['fas', 'eye']" />
                                                        Detail
                                                    </DropdownLink>
                                                    <button type="button" v-if="crud.delete"
                                                        @click="showDeleteModal(item)"
                                                        class="flex justify-start gap-3 w-full px-4 py-1 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                        <font-awesome-icon class="text-red-500 hover:text-red-700"
                                                            :icon="['fas', 'trash-can']" />
                                                        hapus
                                                    </button>


                                                    <DropdownLink v-if="crud.reset_password"
                                                        :href="route(props.path + '.reset.password', { slug: item.user.id })"
                                                        class="flex justify-start gap-3 text-gray-700">
                                                        <font-awesome-icon class="text-blue-500 hover:text-blue-700"
                                                            :icon="['fas', 'key']" />
                                                        Reset Password
                                                    </DropdownLink>
                                                </template>
                                            </dropdownTable>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td :colspan="tableColums.length" class="p-5 text-gray-400 text-center">Data Kosong
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="py-1 px-4 ">
                        <div class="flex flex-wrap">
                            <template v-for="(link, key) in TableData.links">
                                <div v-if="link.url === null" :key="key"
                                    class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                                    v-html="link.label" />
                                <Link v-else :key="`link-${key}`"
                                    class="mb-1 mr-1 px-4 py-3 focus:text-indigo-500 text-sm leading-4 active:border-blue-400 hover:bg-gray-200 border focus:border-indigo-500 rounded"
                                    :class="{ 'bg-white border-blue-500 text-black': link.active }" preserve-state
                                    preserve-scroll :data="{ search, slug, order }" :href="link.url"
                                    v-html="link.label" />
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
