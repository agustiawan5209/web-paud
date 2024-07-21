<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, defineProps } from 'vue';
import {
    FwbSpinner,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
} from 'flowbite-vue'

function whiteSpaceAdd(element) {
    return element.replace(/_|\b_id\b/g, ' ');
}

const props = defineProps({
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
})

console.log(props.tableColums)
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
    <div class="py-4 relative box-content">
        <section class="p-6 bg-gray-100 text-gray-900">
            <form @submit.prevent="submit()" novalidate="" action="" class="container mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mx-auto">
                    <template v-for="(item, index) in tableColums">
                        <div v-if="item != 'id' && item != 'tahun_ajaran'" >
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
                    </template>
                </div>
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
        </section>
    </div>
</template>
