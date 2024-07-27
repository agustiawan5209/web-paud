<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm,usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, defineProps, watch, onMounted, inject } from 'vue';
import axios from 'axios';

// Pesan
const swal = inject('$swal')

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

// props
const props = defineProps({
    kelas: {
        type: Object,
        default: () => ({}),
    },
    siswa: {
        type: Object,
        default: () => ({}),
    },
})

// variabel Form
const Form = useForm({
    kelas_id: '',
    siswa_id: '',
})

const Kelas = ref({
    id: "",
    kode: "",
    keterangan: "",
    tahun_ajaran: "",
})
const Siswa = ref({
    id: "",
    nama: "",
    jenkel: "",
})
const DataKelas = ref({})
const DataSiswa = ref({})
const KelasSearch = ref('')
const SiswaSearch = ref('')

// Form Submit

function submit() {
    Form.post(route('KelasSiswa.store'), {
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
    });
}
// cari data kelas
watch(KelasSearch, (value) => {
    axios.get(route('api.kelas.bySearch', { search: value }))
        .then((res) => {
            if (res.status == 200) {
                DataKelas.value = res.data;
            }
        }).catch((err) => {
            console.log(err)
        })
})
// cari kelas berdasarkan id
const GetKelasID = (id) => {
    axios.get(route('api.kelas.byID', { id: id }))
        .then((res) => {
            if (res.status == 200) {
                Form.kelas_id = res.data.id;
                Kelas.value.kode = res.data.kode;
                Kelas.value.keterangan = res.data.keterangan;
                Kelas.value.tahun_ajaran = res.data.tahun_ajaran;
                DataKelas.value ={}
            }
        }).catch((err) => {
            console.log(err)
        })
}

// cari siswa
watch(SiswaSearch, (value) => {
    axios.get(route('api.siswa.bySearch', { search: value }))
        .then((res) => {
            if (res.status == 200) {
                DataSiswa.value = res.data;
            }
        }).catch((err) => {
            console.log(err)
        })
})

//cari siswa berdasarkan id
const GetSiswaID = (id) => {
    axios.get(route('api.siswa.byID', { id: id }))
        .then((res) => {
            if (res.status == 200) {
                Form.siswa_id = res.data.id;
                Siswa.value.nama = res.data.nama;
                Siswa.value.jenkel = res.data.jenkel;
                DataSiswa.value ={}

            }
        }).catch((err) => {
            console.log(err)
        })
}


</script>

<template>

    <Head title="Kelas Siswa" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Form Tambah Kelas Siswa</h2>
        </template>

        <div class="py-4 relative box-content">
            <section class="p-6 bg-gray-100 text-gray-900">
                <form @submit.prevent="submit()" novalidate="" action=""
                    class="container flex flex-col mx-auto space-y-12">

                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full sm:col-span-3 relative">
                                <label for="firstname" class="text-sm">Kelas</label>
                                <TextInput id="firstname" type="text" placeholder="Kode Kelas" v-model="KelasSearch"
                                    class="w-full text-gray-900" />

                                <div class="absolute top-18" v-if="DataKelas.length > 0">
                                    <ul
                                        class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <template v-for="item in DataKelas" :index="item.kode" :key="item.id">
                                            <li @click="GetKelasID(item.id)"
                                                class="w-full cursor-pointer active:bg-gray-300 px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                                                {{ item.kode }}</li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-span-full sm:col-span-3 relative flex flex-col">
                                <div>
                                    <label for="firstname" class="text-sm">Kelas</label>
                                    <TextInput :readonly="true" id="firstname" type="text" placeholder="Kelas"
                                        v-model="Kelas.kode" class="w-full read-only:bg-gray-100 text-gray-900" />
                                </div>
                                <div>
                                    <label for="keterangan" class="text-sm">Keterangan</label>
                                    <TextInput :readonly="true" id="keterangan" type="text" placeholder="Keterangan"
                                        v-model="Kelas.keterangan" class="w-full read-only:bg-gray-100 text-gray-900" />
                                </div>
                                <div>
                                    <label for="thn" class="text-sm">Tahun Ajaran</label>
                                    <TextInput :readonly="true" id="thn" type="text" placeholder="Tahun Ajaran"
                                        v-model="Kelas.tahun_ajaran" class="w-full read-only:bg-gray-100 text-gray-900" />
                                </div>

                            </div>
                        </div>
                        <hr class="border-2 border-gray-600 col-span-full">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full sm:col-span-3 relative">
                                <label for="firstname" class="text-sm">Siswa</label>
                                <TextInput id="firstname" type="text" placeholder="nama lengkap" v-model="SiswaSearch"
                                    class="w-full text-gray-900" />

                                <div class="absolute top-18" v-if="DataSiswa.length > 0">
                                    <ul
                                        class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <template v-for="item in DataSiswa" :index="item.kode" :key="item.id">
                                            <li @click="GetSiswaID(item.id)"
                                                class="w-full cursor-pointer active:bg-gray-300 px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                                                {{ item.nama }}</li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-span-full sm:col-span-3 relative flex flex-col">
                                <div>
                                    <label for="firstname" class="text-sm">Nama Siswa</label>
                                    <TextInput :readonly="true" id="firstname" type="text" placeholder="Nama Siswa"
                                        v-model="Siswa.nama" class="w-full read-only:bg-gray-100 text-gray-900" />
                                </div>
                                <div>
                                    <label for="keterangan" class="text-sm">Jenis Kelamin</label>
                                    <TextInput :readonly="true" id="keterangan" type="text" placeholder="Jenis Kelamin"
                                        v-model="Siswa.jenkel" class="w-full read-only:bg-gray-100 text-gray-900" />
                                </div>

                            </div>
                        </div>
                        <PrimaryButton type="submit" class="col-span-full text-center">Simpan</PrimaryButton>
                    </fieldset>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
