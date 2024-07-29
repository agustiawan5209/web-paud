<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage,Link } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import { ref, defineProps, watch, onMounted } from 'vue';

const page = usePage();
const props = defineProps({
    orangTua: {
        type: Object,
        default: () => ({})
    },
    can: {
        type: Object,
        default: () => ({})
    }
})
const Form = useForm({
    nama: '',
    tgl_lahir: '',
    jenkel: '',
    org_tua_id: props.orangTua.id,
})


// Create a local reactive variable initialized to the value of the isOpen prop
const ModalVar = ref(false)
const isOpen = ref(false)
function OpenModal() {
    ModalVar.value = true;
}
function close() {
    ModalVar.value = false;
}

function submit() {
    Form.post(route('Siswa.store'), {
        onError: (err) => {
            console.log(err);
        },
        onFinish: () => {
            ModalVar.value = false;
            Form.reset();
        }
    });
}

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

const HitungUsia = (tgl) => {
    const DateNow = new Date();
    const current_date = DateNow.getTime();
    const tgl_lahir = new Date(tgl);
    const ageInMs = current_date - tgl_lahir.getTime();

    const ageInYears = Math.floor(ageInMs / 31536000000);
    const remainingMs = ageInMs % 31536000000;
    const months = Math.floor(remainingMs / 2592000000);
    const days = Math.floor((remainingMs % 2592000000) / 86400000);
    return `Usia: ${ageInYears} Tahun, ${months} Bulan, ${days} Hari`;
}
console.log(props.can)
</script>

<template>

    <Head title="OrangTua" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Form Detail OrangTua</h2>
        </template>

        <Modal :show="ModalVar">
            <section class="p-6 bg-gray-100 text-gray-900">
                <form @submit.prevent="submit()" novalidate="" action=""
                    class="container flex flex-col mx-auto space-y-12">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Form Tambah Siswa</p>
                        <p class="text-xs">. Nama Orang Tua = {{ orangTua.nama }}</p>
                    </div>
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full sm:col-span-3">
                                <label for="firstname" class="text-sm">Nama Lengkap Anak</label>
                                <TextInput id="firstname" type="text" placeholder="nama lengkap" v-model="Form.nama"
                                    class="w-full text-gray-900 text-sm" />
                                <InputError :message="Form.errors.nama" />
                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="tgl_lahir" class="text-sm">Tanggal Lahir</label>
                                <TextInput id="tgl_lahir" type="date" v-model="Form.tgl_lahir"
                                    class="w-full text-gray-900 text-sm" />
                                <InputError :message="Form.errors.tgl_alhir" />

                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="jenkel" class="text-sm mb-8">Jenis Kelamin</label>

                                <div class="flex items-center gap-4">
                                    <div class="flex items-center">
                                        <input id="jenkel-1" type="radio" value="Laki-Laki" name="jenkel"
                                            v-model="Form.jenkel"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500  focus:ring-2 ">
                                        <label for="jenkel-1"
                                            class="ms-2 text-sm font-medium text-gray-900">Laki-Laki</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="jenkel-2" type="radio" value="Perempuan" name="jenkel"
                                            v-model="Form.jenkel"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500  focus:ring-2 ">
                                        <label for="jenkel-2"
                                            class="ms-2 text-sm font-medium text-gray-900">Perempuan</label>
                                    </div>
                                </div>

                                <InputError :message="Form.errors.jenkel" />

                            </div>
                        </div>
                        <PrimaryButton type="submit" class="col-span-full text-center">Simpan</PrimaryButton>
                        <PrimaryButton type="button" class="col-span-full text-center bg-red-500" @click="close()">
                            Batal</PrimaryButton>
                    </fieldset>
                </form>
            </section>
        </Modal>
        <div class="md:py-4 relative box-content">
           <section class=" py-2 px-0 md:px-6  md:py-6 bg-primary text-dark">
                <form novalidate="" action="" class="container flex flex-col mx-auto space-y-12">
                    <div class="space-y-2 col-span-full lg:col-span-1 px-3 md:px-0">
                        <p class="font-medium">Data Informasi OrangTua</p>
                        <p class="text-xs">Edit data Orang Tua {{ orangTua.nama }} dari </p>
                    </div>
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full sm:col-span-3 ">
                                <ul class="flex flex-col space-y-20">
                                    <li class="flex gap-3 py-2 border-b">
                                        <span class="text-lg">Detail Orang Tua</span>
                                    </li>
                                </ul>

                                <table class="w-full table">
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Nama</td>
                                        <td class="text-sm border-b text-gray-600">: {{ orangTua.nama }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">No. Telpon</td>
                                        <td class="text-sm border-b text-gray-600">: {{ orangTua.no_telpon }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Alamat</td>
                                        <td class="text-sm border-b text-gray-600">: {{ orangTua.alamat }} </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <ul class="flex flex-col space-y-20">
                                    <li class="flex gap-3 py-2 border-b">
                                        <span class="text-lg">Detail Pengguna</span>
                                    </li>
                                </ul>
                                <table>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Username Pengguna</td>
                                        <td class="text-sm border-b text-gray-600"> {{ orangTua.user.username }} </td>
                                    </tr>
                                    <tr class="">
                                        <td class="text-sm border-b py-2 font-bold">Email Pengguna</td>
                                        <td class="text-sm border-b text-gray-600"> {{ orangTua.user.email }} </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="w-full md:p-6 rounded-md shadow-sm bg-gray-50">

                        <table class="w-full overflow-x-auto">
                            <caption class="py-2 border-b" >
                                <div class="relative max-w-full flex ">
                                    <PrimaryButton type="button" @click="OpenModal()" v-if="can.add"
                                        class="w-[20%] !text-xs whitespace-nowrap capitalize">Tambah Data Siswa
                                    </PrimaryButton>

                                    <span class="text-lg w-full text-center">Data Siswa</span>
                                </div>
                            </caption>
                            <thead>
                                <tr>
                                    <th class="border border-gray-600 capitalize text-sm py-2">No.</th>
                                    <th class="border border-gray-600 capitalize text-sm py-2">Nama</th>
                                    <th class="border border-gray-600 capitalize text-sm py-2">Usia</th>
                                    <th class="border border-gray-600 capitalize text-sm py-2">Jenis Kelamin</th>
                                    <th class="border border-gray-600 capitalize text-sm py-2">Tanggal Lahir</th>
                                    <th class="border border-gray-600 capitalize text-sm py-2">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-xs" v-for="(item, idx) in orangTua.siswa" :key="item.id">
                                    <td class="px-1 md:px-3 py-2 border border-gray-600">{{ idx + 1 }}</td>
                                    <td class="px-1 md:px-3 py-2 border border-gray-600">
                                        {{ item.nama }}
                                    </td>
                                    <td class="px-1 md:px-3 py-2 border border-gray-600">
                                        {{ item.hitung_usia }}
                                    </td>
                                    <td class="px-1 md:px-3 py-2 border border-gray-600">
                                        {{ item.jenkel }}

                                    </td>
                                    <td class="px-1 md:px-3 py-2 border border-gray-600">
                                        {{ item.tgl_lahir }}
                                    </td>
                                    <td class="px-1 md:px-3 py-2 border border-gray-600">
                                        <Link
                                            :href="route('Siswa.show', { slug: item.id })"
                                            class="flex justify-start gap-3">
                                            <font-awesome-icon class="text-blue-500 hover:text-blue-700"
                                                :icon="['fas', 'eye']" />
                                            Detail
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </fieldset>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
