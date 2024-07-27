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
    kelas_id: props.kelas.id,
    kode: props.kelas.kode,
    nama: props.kelas.kode,
    tanggal: '',
    siswa: [],
})

const AbsensSiswa = ref([]);

// Buat Data Input Kehadiran
onMounted(()=>{
    const KelasData = props.kelas.kelassiswa;
    for (let index = 0; index < KelasData.length; index++) {
        const element = KelasData[index];
        AbsensSiswa.value.push({
            siswa_id : element.siswa.id,
            nama : element.siswa.nama,
            absen: 'Tidak Hadir',
        })

    }
})

function submit() {

    Form.siswa = AbsensSiswa.value;
    Form.post(route('Absen.store'), {
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
            <h2>Form Tambah Kelas</h2>
        </template>

        <div class="py-4 relative box-content">
            <section class="p-6 bg-gray-100 text-gray-900">
                <form @submit.prevent="submit()" novalidate="" action=""
                    class="container flex flex-col mx-auto space-y-12">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Buat Absensi Kelas {{ kelas.kode }}</p>
                    </div>
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50 relative box-content">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full">
                                <label for="kode" class="text-sm">kode Kelas</label>
                                <TextInput id="kode" type="text" placeholder="..............." v-model="Form.kode"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.kelas_id" />

                            </div>
                            <div class="col-span-full">
                                <label for="tanggal" class="text-sm">Tanggal</label>
                                <TextInput id="tanggal" type="date" placeholder="..............." v-model="Form.tanggal"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.tanggal" />

                            </div>
                            <div class="col-span-full">


                                <div class="relative overflow-x-auto border shadow-md sm:rounded-lg">
                                    <table
                                        class="w-full text-sm text-left rtl:text-right text-gray-500">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-2 py-3">
                                                    No.
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Nama Siswa
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Kehadiran
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,index) in AbsensSiswa" :key="item.id"
                                                class="odd:bg-white even:bg-gray-50 border-b">
                                                <td scope="row"
                                                    class="px-2 py-4 border ">
                                                    {{index+1}}
                                                </td>
                                                <td class="px-6 py-4 border">
                                                    {{ item.nama }}
                                                </td>
                                                <td class="px-6 py-4 border">
                                                    <div class="grid grid-cols-2 gap-6">
                                                        <div class="flex items-center">
                                                          <fwb-radio v-model="item.absen" label="Hadir" :name="'radio-absen'+index" value="Hadir" />
                                                        </div>
                                                        <div class="flex items-center">
                                                          <fwb-radio v-model="item.absen" label="Tidak Hadir" :name="'radio-absen'+index" value="Tidak Hadir" />
                                                        </div>
                                                      </div>
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
