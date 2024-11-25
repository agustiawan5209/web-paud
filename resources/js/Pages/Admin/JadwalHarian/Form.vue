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
import { ref, defineProps, watch, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    user: {
        type: Object,
        default: () => ({})
    }
})
const Form = useForm({
    kelas_id: '',
    tgl: '',
    end_date: '',
    jadwal: [],
    penanggung_jawab: '',
})



const DataPj = ref({})
const PjSearch = ref('')
const PjID = ref('')

watch(PjSearch, (value) => {
    axios.get(route('api.Guru.data', { search: value }))
        .then((res) => {
            if (res.status == 200) {
                DataPj.value = res.data;
            }
        }).catch((err) => {
            console.log(err)
        })
})

const GetPjID = (id) => {
    axios.get(route('api.Guru.byID', { id: id }))
        .then((res) => {
            if (res.status == 200) {
                Form.penanggung_jawab = res.data.nama;
                PjID.value = res.data.id;
                PjSearch.value = res.data.nama;
                DataPj.value = {}
            }
        }).catch((err) => {
            console.log(err)
        })
}
const DataKelas = ref({})
const KelasSearch = ref('')
const KelasID = ref('')

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

const GetKelasID = (id) => {
    axios.get(route('api.kelas.byID', { id: id }))
        .then((res) => {
            if (res.status == 200) {
                Form.kelas_id = id;
                KelasID.value = res.data.kode;
                KelasSearch.value = `Kelas = ${res.data.kode} || Tahun Ajaran = ${res.data.tahun_ajaran}`;
                DataKelas.value = {}
            }
        }).catch((err) => {
            console.log(err)
        })
}

const jmlKegiatan = ref(0)



const Jadwal = ref([])
const jadwalJam = ref([
])
const jadwalkegiatan = ref([
])
const jadwalPengembangan = ref([
])

function plusJadwal() {
    jmlKegiatan.value++;
}

function deleteSlice(index) {
    jmlKegiatan.value -= 1
    JadwalHarian.value.splice(index);
    jadwalJam.value.splice(index);
    jadwalkegiatan.value.splice(index);
    jadwalPengembangan.value.splice(index);

}


function submit() {
    for (let i = 0; i < jmlKegiatan.value; i++) {
        Form.jadwal.push({
            jam: jadwalJam.value[i],
            kegiatan: jadwalkegiatan.value[i],
            pengembangan: jadwalPengembangan.value[i],
        })

    }
    Form.post(route('JadwalHarian.store'), {
        preserveState: true,
        onError: (err) => {
            console.log(err)
        }
    });
}

</script>

<template>

    <Head title="Form Jadwal" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Form Tambah Form Jadwal</h2>
        </template>

        <div class="py-4 relative box-content">
            <section class="p-6 bg-gray-100 text-gray-900">
                <form @submit.prevent="submit()" novalidate="" action=""
                    class="container flex flex-col mx-auto space-y-12">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Data Informasi Form Jadwal</p>
                        <p class="text-xs">Catatan : Jadwal kelas akan ditambahkan berdasarkan data Harian <br>
                        </p>

                    </div>
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50 relative box-content">
                        <div class="grid grid-cols-6 gap-4 md:grid-cols-4 col-span-full md:col-span-4">
                            <div class="col-span-full relative">
                                <label for="firstname" class="text-sm">Kelas</label>
                                <TextInput id="firstname" type="text" placeholder="Kode Kelas" v-model="KelasSearch"
                                    class="w-full text-gray-900" />

                                <div class="absolute top-18 z-10" v-if="DataKelas.length > 0">
                                    <ul
                                        class="w-96 z-10 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <template v-for="item in DataKelas" :index="item.kode" :key="item.id">
                                            <li @click="GetKelasID(item.id)"
                                                class="w-full cursor-pointer active:bg-gray-300 px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                                                Kelas={{ item.kode }} || Tahun Ajaran ={{ item.tahun_ajaran }}</li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-span-full md:col-span-2 relative">
                                <label for="star_date" class="text-sm">Tanggal </label>
                                <TextInput id="star_date" type="date" placeholder="tanggal" v-model="Form.tgl"
                                    class="w-full text-gray-900" />

                            </div>
                            <div class="col-span-full bg-white border border-gray-500 p-2 rounded-md">
                                <table class="table w-full p-2 bg-white">
                                    <tr class="bg-orange-200">
                                        <th class="border border-black">Jam</th>
                                        <th class="border border-black">Kegiatan</th>
                                        <th class="border border-black">Pengembangan</th>
                                        <th class="border border-black">Hapus</th>
                                    </tr>

                                    <tr v-for="(item, index) in jmlKegiatan">
                                        <td class="p-1.5 border border-gray-300">
                                            <div class="col-span-full sm:col-span-2">
                                                <TextInput required id="jam" type="text" placeholder="Jam Kegiatan"
                                                    class="w-full text-gray-900" v-model="jadwalJam[index]" />

                                            </div>
                                        </td>
                                        <td class="p-1.5 border border-gray-300">
                                            <div class="col-span-full sm:col-span-2">
                                                <TextInput required id="senin" type="text" placeholder="nama kegiatan..."
                                                    class="w-full text-gray-900" v-model="jadwalkegiatan[index]" />

                                            </div>
                                        </td>
                                        <td class="p-1.5 border border-gray-300">
                                            <div class="col-span-full sm:col-span-2">
                                                <TextInput required id="senin" type="text" placeholder="nama kegiatan..."
                                                    class="w-full text-gray-900" v-model="jadwalPengembangan[index]" />

                                            </div>
                                        </td>
                                        <td class="p-1.5 border border-gray-300">
                                            <button @click="deleteSlice(index)" type="button"
                                                class="p-4 bg-red-400 rounded-md h-1/2">X</button>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td colspan="6">
                                            <PrimaryButton @click="plusJadwal()" type="button">Tambah Jadwal
                                            </PrimaryButton>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-span-full sm:col-span-2 relative">
                            <label for="penanggung_jawab" class="text-sm">Penanggung Jawab</label>
                            <TextInput id="penanggung_jawab" type="search" placeholder="Penanggung Jawab"
                                v-model="PjSearch" class="w-full text-gray-900" />

                            <div class="absolute top-18 z-50" v-if="DataPj.length > 0">
                                <ul
                                    class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <template v-for="item in DataPj" :index="item.nama" :key="item.id">
                                        <li @click="GetPjID(item.id)"
                                            class="w-full cursor-pointer active:bg-gray-300 px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                                            {{ item.nama }}</li>
                                    </template>
                                </ul>
                            </div>

                            <InputError :message="Form.errors.penanggung_jawab" />
                        </div>


                        <PrimaryButton type="submit" class="col-span-full mt-20 text-center z-[100]">Simpan
                        </PrimaryButton>
                    </fieldset>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
