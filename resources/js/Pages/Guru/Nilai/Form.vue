<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, defineProps, watch, onMounted, inject } from 'vue';
import axios from 'axios';
import { FwbRadio } from 'flowbite-vue'
import { text } from '@fortawesome/fontawesome-svg-core';

import { FwbFileInput } from 'flowbite-vue'

const swal = inject('$swal')

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
const Form = useForm({
    kelas_id: '',
    kode: '',
    nama: '',
    tanggal: '',
    siswa: [],
    image: [],
})

const AbsensSiswa = ref([]);

// Get Data Nilai Siswa Jika Tersedia
const TanggalKelas = ref('');

function SearchAbsen(tanggal) {
    if (tanggal) {
        axios.get(route('api.getNilaiSiswa', { tanggal: tanggal, kelas_id: Form.kelas_id }))
            .then((res) => {
                if (res.status == 200) {
                    console.log(res.data)
                    const StatusAbsen = res.data.status;
                    if (StatusAbsen === true) {
                        swal({
                            title: "Peringatan",
                            icon: "error",
                            html: `<strong>Data Nilai Siswa ${TanggalKelas.value} Sudah Tersedia</strong>
                        <br>
                        `,
                            showCloseButton: true,
                            showCancelButton: true,
                        });
                        AbsensSiswa.value = [];
                    } else {
                        Form.tanggal = tanggal;
                    }
                }
            }).catch((err) => {
                console.error(err);
            })
    }
}

// Cari Data Kelas Berdasarkan ID
// Variabel ID Kelas
const kelasId = ref('');

function Search(id) {
    axios.get(route('api.kelas.byID', { id: id }))
        .then((res) => {
            if (res.status == 200) {
                SearchAbsen(TanggalKelas.value);
                AbsensSiswa.value = []
                Form.kelas_id = res.data.id;
                const Kelas_Siswa = res.data.kelassiswa;
                if (Kelas_Siswa.length < 1) {
                    swal({
                        title: "Peringatan",
                        icon: "error",
                        html: `<strong>Tidak Ada List Siswa Di Kelas: ${res.data.kode}/${res.data.tahun_ajaran}</strong>
                        <br>
                        <p>Hubungi Admin!!</p>
                        `,
                        showCloseButton: true,
                        showCancelButton: true,
                    });
                } else {
                    for (let index = 0; index < Kelas_Siswa.length; index++) {
                        const element = Kelas_Siswa[index];
                        AbsensSiswa.value.push({
                            siswa_id: element.siswa.id,
                            nama: element.siswa.nama,
                            nilai: 0,
                        })

                    }
                }
            }
        }).catch((err) => {
            console.error(err);
        })
}



onMounted(() => {
    watch(kelasId, (value) => {
        Search(value);
    })
    watch(TanggalKelas, (value) => {
        SearchAbsen(value);
    })
})


// Multiple Image
const imagePreviews = ref([]);
const ImageUpload = ref([]);
const handleFileUpload = (event) => {
    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
        ImageUpload.value.push(files[i])
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreviews.value.push(e.target.result);
        };
        reader.readAsDataURL(files[i]);
    }
};

const removeImage = (index) => {
    imagePreviews.value.splice(index, 1);
    ImageUpload.value.splice(index, 1);
};

// Post
function submit() {
    // console.log(imagePreviews.value)
    Form.siswa = AbsensSiswa.value;
    Form.image = ImageUpload;
    Form.post(route('NilaiSiswa.store'), {
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

const editorOptions = {
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{ 'header': 1 }, { 'header': 2 }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            [{ 'script': 'sub' }, { 'script': 'super' }],
            [{ 'indent': '-1' }, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'font': [] }],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'align': [] }],
            ['clean'],
            ['link', 'image', 'video']
        ],
        syntax: {
            highlight: text => hljs.highlightAuto(text).value
        }
    }
}

</script>

<template>

    <Head title="Kelas" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Form Nilai Siswa Kelas</h2>
        </template>

        <div class="py-4 relative box-content">
            <section class="p-6 bg-gray-100 text-gray-900">
                <form @submit.prevent="submit()" novalidate="" action=""
                    class="container flex flex-col mx-auto space-y-12">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Buat Nilai Siswa Kelas</p>
                    </div>
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50 relative box-content">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">

                            <div class="col-span-full">
                                <InputLabel for="kelas" value="Kelas" />
                                <select id="kelas" v-model="kelasId"
                                    class="px-2 py-1 md:px-3 md:py-2 placeholder-gray-400 border focus:outline-none  w-full sm:text-sm border-gray-200 shadow-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none ">
                                    <option value="">-----</option>
                                    <option v-for="item in kelas" :value="item.id">{{ item.kode }}-
                                        {{ item.tahun_ajaran }}
                                    </option>
                                </select>

                            </div>
                            <div class="col-span-full">


                                <div class="relative overflow-x-auto border shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-2 py-3">
                                                    No.
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Nama Siswa
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Nilai Siswa
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in AbsensSiswa" :key="item.id"
                                                class="odd:bg-white even:bg-gray-50 border-b">
                                                <td scope="row" class="px-2 py-4 border ">
                                                    {{ index + 1 }}
                                                </td>
                                                <td class="px-6 py-4 border">
                                                    {{ item.nama }}
                                                </td>
                                                <td class="px-6 py-4 border">
                                                    <Link
                                                        :href="route('NilaiSiswa.form', { siswa: item.siswa_id, kelas: Form.kelas_id })">
                                                    <PrimaryButton type="button">Buat Laporan</PrimaryButton>

                                                    </Link>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </fieldset>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
