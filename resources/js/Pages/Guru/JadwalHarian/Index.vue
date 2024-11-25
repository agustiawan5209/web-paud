<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref, watch, defineProps, onMounted, inject } from 'vue';
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import dropdownTable from '@/Components/dropdownTable.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
const swal = inject('$swal')

const page = usePage()

onMounted(() => {
    if (page.props.message !== null) {
        swal({
            icon: "info",
            title: 'Berhasil',
            text: page.props.message,
            showConfirmButton: true,
            timer: 2000
        });
    }
})
function messageDisplay(message, icon) {
    swal({
        icon: icon,
        title: 'Perhatian!!',
        text: message,
        showConfirmButton: true,
        timer: 2000
    });
}
const props = defineProps({
    search: {
        type: String,
        default: '',
    },
    order: {
        type: String,
        default: '',
    },
    date: {
        type: String,
        default: '',
    },
    kelas_id: {
        type: String,
        default: '',
    },
    jadwal: {
        type: Object,
        default: () => ({}),
    },
    kelas: {
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

const Form = useForm({
    search: props.search,
    date: props.date,
    order: props.order,
    kelas_id: props.kelas_id
})

const search = ref(props.search)
const order = ref(props.order)
const date = ref(props.date)
const KelasSearch = ref(props.kelas_id)
// Filter By

watch(search, (value) => {
    Form.search = value
    Form.get(route('Guru.JadwalHarian.index'), {
        preserveScroll: true,
        preserveState: true,
    })
})
watch(order, (value) => {
    Form.order = value
    Form.get(route('Guru.JadwalHarian.index'), {
        preserveScroll: true,
        preserveState: true,
    })
})
watch(date, (value) => {
    Form.date = value
    Form.get(route('Guru.JadwalHarian.index'), {
        preserveScroll: true,
        preserveState: true,
    })
})
watch(KelasSearch, (value) => {
    Form.kelas_id = value
    Form.get(route('Guru.JadwalHarian.index'), {
        preserveScroll: true,
        preserveState: true,
    })
})

function resetFilter() {
    search.value = '';
    date.value = '';
}
//
const crud = ref({
    tambah: props.can.add,
    edit: props.can.edit,
    show: props.can.show,
    delete: props.can.delete,
    reset_password: props.can.reset,

})
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
    DeleteForm.delete(route('Guru.JadwalHarian.destroy'), {
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

// Cetak

</script>

<template>

    <Head title="Jadwal" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-100 leading-tight">Data Jadwal</h2>
        </template>


        <div class="py-4 relative box-content">
            <div class="border divide-y divide-gray-200 max-w-7xl mb-8 overflow-hidden rounded-lg shadow-xs bg-white">

                <div class="py-3 px-4 flex justify-between">
                    <div class="flex gap-4">
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
                        <div class="relative max-w-xs">
                            <label class="sr-only">Tanggal Layanan</label>
                            <input type="date" name="hs-table-with-pagination-date" id="hs-table-with-pagination-date"
                                v-model="date"
                                class="py-1 md:py-2 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        </div>
                        <div class="relative max-w-xs flex items-center gap-2 border-l pl-1">
                            <label for='kelas' class="capitalize text-xs md:text-sm">Kelas</label>

                            <select id="kelas" v-model="KelasSearch"
                                class="px-2 py-1 md:px-3 md:py-2 placeholder-gray-400 border focus:outline-none sm:w-40 sm:text-sm border-gray-200 shadow-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none ">
                                <option value="">-----</option>
                                <option v-for="item in kelas" :value="item.id">{{ item.kode }}</option>
                            </select>
                        </div>
                        <div class="relative max-w-xs">
                            <button type="reset" @click="resetFilter()"
                                class="py-1 md:py-2 border px-2 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">Reset</button>
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
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="px-2 py-1 md:px-6 md:py-3 text-nowrap text-start font-medium capitalize bg-blue-600 text-white">
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Nama Kels</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <!-- <th class="px-4 py-3">Nama Jadwal</th> -->
                                <!-- <th class="px-4 py-3">Keterangan</th> -->
                                <th class="px-4 py-3">Penanggung Jawab</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class=" divide-y divide-gray-700 bg-white" v-if="jadwal.data.length"
                            :class="{ 'opacity-75 blur-sm': Form.processing }">
                            <tr class="text-gray-900" v-for="(item, index) in jadwal.data">
                                <td class="px-4 py-3 border">
                                    {{ (jadwal.current_page - 1) * jadwal.per_page + index + 1 }}
                                </td>
                                <td class="px-4 py-3 border text-sm">
                                    {{ item.nama_kelas }}
                                </td>
                                <td class="px-4 py-3 border text-sm">
                                    {{ item.tgl }}
                                </td>
                                <!-- <td class="px-4 py-3 border text-sm">
                                    {{ item.deskripsi }}
                                </td> -->
                                <td class="px-4 py-3 border text-sm">
                                    {{ item.penanggung_jawab }}
                                </td>
                                <td class="px-4 py-3 border text-sm">
                                    <div class="ml-3 relative z-50"
                                        v-if="crud.edit || crud.show || crud.delete || crud.reset_password">
                                        <dropdownTable align="top" width="48" :key="index">
                                            <template #trigger>
                                                <span class="inline-flex rounded-md">
                                                    <button type="button"
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-primary hover:text-white focus:bg-primary focus:text-white focus:outline-none transition ease-in-out duration-150">
                                                        Aksi

                                                        <font-awesome-icon :icon="['fas', 'ellipsis-vertical']"
                                                            class="ml-2 -mr-0.5 h-4 w-4" />

                                                    </button>
                                                </span>
                                            </template>

                                            <template #content>

                                                <DropdownLink v-if="crud.show"
                                                    :href="route('Guru.JadwalHarian.show', { slug: item.id })"
                                                    class="flex justify-start gap-3 text-gray-700">
                                                    <font-awesome-icon class="text-blue-500 hover:text-blue-700"
                                                        :icon="['fas', 'eye']" />
                                                    Detail
                                                </DropdownLink>
                                            </template>
                                        </dropdownTable>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody class="divide-y divide-gray-700 bg-gray-200" v-else>
                            <tr>
                                <td colspan="7" class="p-5 text-gray-900 text-center">Data Kosong</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="py-1 px-4 ">
                    <div class="flex flex-wrap">
                        <template v-for="(link, key) in jadwal.links">
                            <div v-if="link.url === null" :key="key"
                                class="mb-1 mr-1 px-4 py-3 text-gray-900 text-sm leading-4 border rounded"
                                v-html="link.label" />
                            <Link v-else :key="`link-${key}`"
                                class="mb-1 mr-1 px-4 py-3 focus:text-indigo-500 text-sm leading-4 active:border-blue-400 hover:bg-gray-200 border focus:border-indigo-500 rounded"
                                :class="{ 'bg-white border-blue-500 text-black': link.active }" preserve-state
                                preserve-scroll :data="{ search, order }" :href="link.url" v-html="link.label" />
                        </template>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
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
</template>
