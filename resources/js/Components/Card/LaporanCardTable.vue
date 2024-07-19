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
        return 'Pasien'
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
        <div class="flex flex-col max-w-full gap-2 p-6 rounded-md shadow-md bg-gray-50 text-gray-800">
            <h2 class="flex items-center gap-2 text-xl font-semibold leading-tight tracking-wide">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                    class="w-6 h-6 fill-current shrink-0 text-violet-600">
                    <path
                        d="M451.671,348.569,408,267.945V184c0-83.813-68.187-152-152-152S104,100.187,104,184v83.945L60.329,348.568A24,24,0,0,0,81.432,384h86.944c-.241,2.636-.376,5.3-.376,8a88,88,0,0,0,176,0c0-2.7-.135-5.364-.376-8h86.944a24,24,0,0,0,21.1-35.431ZM312,392a56,56,0,1,1-111.418-8H311.418A55.85,55.85,0,0,1,312,392ZM94.863,352,136,276.055V184a120,120,0,0,1,240,0v92.055L417.137,352Z">
                    </path>
                    <rect width="32" height="136" x="240" y="112"></rect>
                    <rect width="32" height="32" x="240" y="280"></rect>
                </svg>
                <span>Apakah anda yakin ingin menghapus {{ DeleteForm.title }}</span>
            </h2>
            <!-- <p class="flex-1 text-gray-600">Mauris et lorem at elit tristique dignissim et ullamcorper elit. In sed feugiat mi. Etiam ut lacinia dui.</p> -->
            <div class="flex flex-col justify-end gap-3 mt-6 sm:flex-row">
                <button class="px-6 py-2 rounded-sm" @click="VarDeleteModal = false">Tidak</button>
                <button class="px-6 py-2 rounded-sm shadow-sm bg-violet-600 text-gray-50"
                    @click="deleteItem()">Ya</button>
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
                                                class="inline-flex items-center justify-center rounded-full bg-green-100 px-2.5 py-0.5 text-green-700">

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
                                                        <font-awesome-icon class="text-green-500 hover:text-green-700"
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
