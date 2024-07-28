<script setup>

import { Head, useForm, Link, usePage } from '@inertiajs/vue3';
import { ref, watch, defineProps, inject, defineExpose, onMounted } from 'vue';
import dropdownTable from '@/Components/dropdownTable.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import Modal from '@/Components/Modal.vue';
import Dropdown from '@/Components/Dropdown.vue';
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

import {
    FwbSpinner,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
} from 'flowbite-vue'
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
    relasi: {
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


function whiteSpaceAdd(element) {
    return element.replace(/_|\b_id\b/g, ' ');
}
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


function truncateText(text) {
    var paragraphs = text
    var text = '';
    var paragraph = ''
    for (var i = 0; i < paragraphs.length; i++) {
        if (i < 50) {
            text += paragraphs[i]
        }
    }
    if(paragraphs.length>50){
        text += '........'
    }
    return text;
}

// Form Create
const tabelkolom = props.tableColums.reduce((acc, element, index) => {
    acc[element] = '';
    return acc;
}, {});

const FormCreate = useForm(tabelkolom);



function storeUpdate() {
    console.log(FormCreate)
    FormCreate.post(route(props.path + ".store"), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            swal({
                icon: "success",
                title: 'Berhasil',
                text: `Data ${props.path} Berhasil ditambahkan!!`,
                showConfirmButton: true,
                timer: 2000
            });
            FormCreate.reset()
        },
        onError: (err) => {
            var txt = "<ul>"
            Object.keys(err).forEach((item, val) => {
                txt += `<li>${err[item]}</li>`
            });
            txt += "</ul>";
            console.log(txt)
            swal({
                title: "Peringatan",
                icon: "error",
                html: txt,
                showCloseButton: true,
                showCancelButton: true,
            });
        }
    })
}

const EditForm = ref(false)
function getDataID(id) {
    axios.get(route(props.path + '.edit', { slug: id }))
        .then((res) => {
            if (res.status == 200) {
                Object.keys(tabelkolom).forEach((item) => {
                    FormCreate[item] = res.data[item]
                });
                console.log(FormCreate)
                EditForm.value = true;
            }
        })
        .catch(err => {
            console.log(err)
        })
}

function editUpdate() {
    FormCreate.put(route(props.path + ".update"), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            swal({
                icon: "info",
                title: 'Berhasil',
                text: `Data ${props.path} Berhasil Di Ubah!!`,
                showConfirmButton: true,
                timer: 2000
            });
            EditForm.value = false;
            FormCreate.reset()
        },
        onError: (err) => {
            var txt = "<ul>"
            Object.keys(err).forEach((item, val) => {
                txt += `<li>${err[item]}</li>`
            });
            txt += "</ul>";
            console.log(txt)
            swal({
                title: "Peringatan",
                icon: "error",
                html: txt,
                showCloseButton: true,
                showCancelButton: true,
            });
        }
    })
}
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
        <div class="grid grid-cols-1  md:grid-cols-12 gap-2">
            <div class="md:col-span-4 p-1.5 border rounded-lg">
                <form @submit.prevent="EditForm ? editUpdate() : storeUpdate()" class="relative my-5">
                    <template v-for="(item, index) in tableColums">
                        <div v-if="item != 'id' && item != 'tahun_ajaran' && item != 'guru'" class="mt-3">
                            <label :for="item"
                                class=" capitalize block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{
                                    whiteSpaceAdd(item)
                                }}</label>
                            <input type="text" v-model="FormCreate[item]" :id="item"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                :placeholder="whiteSpaceAdd(item)" required />
                        </div>
                        <div v-else-if="item == 'tahun_ajaran'">
                            <label for="countries"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{
                                    whiteSpaceAdd(item) }}</label>
                            <select id="countries" v-model="FormCreate[item]"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">---Pilih---</option>
                                <option v-for="col in relasi.tahun_ajarans" :value="col.tahun">{{ col.tahun }}</option>
                            </select>
                        </div>
                        <div v-else-if="item == 'guru'">
                            <label for="countries"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Guru</label>
                            <select id="countries" v-model="FormCreate[item]"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">---Pilih---</option>
                                <option v-for="col in relasi.gurus" :value="col.id">{{ col.nama }}</option>
                            </select>
                        </div>
                    </template>
                    <hr class="border-2 my-5">
                    <PrimaryButton v-if="EditForm" type="submit" class="w-full text-center !bg-blue-500">
                        <span v-if="FormCreate.processing" class="flex justify-center">
                            <fwb-spinner color="blue" size="6" />
                        </span>
                        <span v-else class="flex justify-center">
                            Edit Data
                        </span>

                    </PrimaryButton>
                    <PrimaryButton v-else type="submit" class="w-full text-center !bg-green-500">
                        <span v-if="FormCreate.processing" class="flex justify-center">
                            <fwb-spinner color="blue" size="6" />
                        </span>
                        <span v-else class="flex justify-center">
                            Tambah Data
                        </span>
                    </PrimaryButton>

                </form>
            </div>
            <div class="md:col-span-8">
                <div
                    class="border divide-y divide-gray-200 max-w-7xl mb-8 overflow-hidden rounded-lg shadow-xs bg-white">

                    <div class="py-3 px-4 flex justify-between">
                        <div class="relative max-w-xs">
                            <label class="sr-only">Search</label>
                            <input type="search" name="hs-table-with-pagination-search"
                                id="hs-table-with-pagination-search" v-model="search"
                                class="pl-2 py-1 md:pl-8 md:py-2 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                placeholder="Cari Data.........">
                            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.3-4.3"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="relative max-w-xs flex items-center gap-2">
                            <label class="capitalize text-xs md:text-sm">Urutkan</label>

                            <select id="order" v-model="order"
                                class="px-2 py-1 md:px-3 md:py-2 placeholder-gray-400 border focus:outline-none sm:w-40 sm:text-sm border-gray-200 shadow-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none ">
                                <option value="">-----</option>
                                <option value="desc">Terbaru</option>
                                <option value="asc">Terlama</option>
                            </select>
                            <div class="absolute inset-y-0 end-3 flex items-center pointer-events-none ps-3">
                                <font-awesome-icon :icon="['fas', 'filter']" class="text-gray-400" />
                            </div>
                        </div>
                    </div>
                    <div class="w-full overflow-x-auto">
                        <fwb-table hoverable striped class="w-full table-full overflow-x-auto">
                            <colgroup>
                                <template v-for="(item, index) in columsReplace">
                                    <col v-if="index == 0" class="w-10">
                                    <col v-else>
                                </template>
                                <col>
                            </colgroup>
                            <fwb-table-head
                                class="text-xs md:text-base font-semibold tracking-wide text-left uppercase border-b border-gray-700  ">
                                <fwb-table-head-cell scope="col" v-for="item in columsReplace"
                                    class="px-2 py-1 md:px-6 md:py-3 text-nowrap text-start font-medium capitalize">
                                    <span v-if="item == 'id' || item == 'slug'" class="w-10">
                                        No.
                                    </span>
                                    <span v-else>{{ item }}</span>
                                </fwb-table-head-cell>
                                <th scope="col" v-if="cekAksi()"
                                    class=" px-2 py-1 md:px-3 md:py-3 text-center font-medium uppercase">Aksi
                                </th>
                            </fwb-table-head>
                            <fwb-table-body  v-if="Form.processing">
                                <tr>
                                    <td :colspan="tableColums.length" class="p-5 text-gray-400 text-center ">
                                        <div class="flex justify-center">
                                            <fwb-spinner color="blue" size="8" />
                                        </div>
                                    </td>
                                </tr>
                            </fwb-table-body>
                            <fwb-table-body class="bg-white divide-y " v-else-if="TableData.data.length > 0">
                                <fwb-table-row v-for="(item, index) in TableData.data" :key="item.id"
                                    class="text-gray-700 dark:text-gray-400">
                                    <fwb-table-cell
                                        class="px-2 py-1 md:px-4 md:py-3  text-xs font-medium text-gray-800 border"
                                        v-for="col in tableColums">

                                        <span v-if="col == 'id' || col == 'slug'">
                                            {{ (TableData.current_page - 1) * TableData.per_page + index + 1 }}
                                        </span>
                                        <span v-else-if="col == 'deskripsi' || col == 'keterangan'">
                                            <p v-html="truncateText(item[col])"></p>
                                        </span>
                                        <span v-else-if="col == 'status'">
                                            <span v-if="item.status == 0 || item.status == '0'"
                                                class="inline-flex items-center justify-center rounded-full bg-green-100 px-2.5 py-0.5 text-green-700">

                                                <p class="whitespace-nowrap text-sm">Tersedia</p>
                                            </span>
                                            <span v-if="item.status == 1 || item.status == '1'"
                                                class="inline-flex items-center justify-center rounded-full bg-amber-100 px-2.5 py-0.5 text-amber-700">

                                                <p class="whitespace-nowrap text-sm">Tidak Tersedia</p>
                                            </span>
                                        </span>
                                        <span v-else :class="col == 'tahun' ? 'whitespace-nowrap' : ''">{{ item[col]
                                            }}</span>
                                    </fwb-table-cell>
                                    <fwb-table-cell
                                        class="w-12 px-2 py-1 md:px-4 md:py-3  text-xs font-medium text-gray-800 border relative"
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
                                                    <button v-if="crud.edit" type="button"
                                                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                                        @click="getDataID(item.id)">
                                                        <font-awesome-icon class="text-green-500 hover:text-green-700"
                                                            :icon="['fas', 'pen-to-square']" />
                                                        Edit
                                                    </button>
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
                                    </fwb-table-cell>
                                </fwb-table-row>

                            </fwb-table-body>
                            <tbody v-else>
                                <tr>
                                    <td :colspan="tableColums.length" class="p-5 text-gray-400 text-center">Data Kosong
                                    </td>
                                </tr>
                            </tbody>
                        </fwb-table>
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
