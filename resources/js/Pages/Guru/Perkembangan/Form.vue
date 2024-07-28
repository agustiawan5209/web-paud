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
import { ref, defineProps, watch, onMounted, inject } from 'vue';
import axios from 'axios';
import { FwbRadio } from 'flowbite-vue'
import { text } from '@fortawesome/fontawesome-svg-core';
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
})

const DataPerkembangan = ref([]);

// Get Data Nilai Siswa Jika Tersedia
const TanggalKelas = ref('');

function SearchAbsen(tanggal) {
    if (tanggal) {
        axios.get(route('api.getKelasPerkembangan', { tanggal: tanggal, kelas_id: Form.kelas_id }))
            .then((res) => {
                if (res.status == 200) {
                    console.log(res.data)
                    const StatusPerkembangan = res.data.status;
                    if (StatusPerkembangan === true) {
                        swal({
                            title: "Peringatan",
                            icon: "error",
                            html: `<strong>Data Nilai Siswa ${TanggalKelas.value} Sudah Tersedia</strong>
                        <br>
                        `,
                            showCloseButton: true,
                            showCancelButton: true,
                        });
                        DataPerkembangan.value = [];
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
                DataPerkembangan.value = []
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
                        DataPerkembangan.value.push({
                            siswa_id: element.siswa.id,
                            nama: element.siswa.nama,
                            perkembangan: '..........',
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

function submit() {

    Form.siswa = DataPerkembangan.value;
    Form.post(route('Perkembangan.store'), {
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
                                <label for="tanggal" class="text-sm">Tanggal</label>
                                <TextInput id="tanggal" type="date" placeholder="..............." v-model="TanggalKelas"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.tanggal" />

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
                                                    Keterangan Perkembangan Siswa
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in DataPerkembangan" :key="item.id"
                                                class="odd:bg-white even:bg-gray-50 border-b">
                                                <td scope="row" class="px-2 py-4 border ">
                                                    {{ index + 1 }}
                                                </td>
                                                <td class="px-6 py-4 border">
                                                    {{ item.nama }}
                                                </td>
                                                <td class="px-6 py-4 border">
                                                    <quill-editor id="deskripsi" contentType="html" theme="snow"
                                                        v-model:content="item.perkembangan" placeholder="@deskripsi"
                                                        class="w-full text-gray-900" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                        <PrimaryButton type="submit" class="col-span-full mt-20 text-center z-[100]">Simpan
                        </PrimaryButton>
                    </fieldset>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
