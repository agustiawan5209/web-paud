<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, defineProps, watch, onMounted } from 'vue';
import axios from 'axios';

const Page = usePage().props.auth;
const Roles = Page.role;

const props = defineProps({
    orangTua: {
        type: Object,
        default: () => ({})
    },
    can: {
        type: Object,
        default: () => ({})
    },
})

function roleToCheck(role) {
    if (Array.isArray(Roles)) {
        return Roles.includes(role)
    }else{
        return false;
    }
}


const Form = useForm({
    nama: '',
    nik: '',
    tempat_lahir: '',
    tgl_lahir: '',
    jenkel: '',
    org_tua_id: roleToCheck('Orang Tua') ? props.orangTua.id : '',
    nama_orang_tua: roleToCheck('Orang Tua') ? props.orangTua.nama : '',

})
function submit() {
    Form.post(route('Siswa.store'), {
        onError: (err) => {
            console.log(err)
        },
        onSuccess:()=>{
            Form.reset();
        }
    });
}

const PJ = ref('');
const changeSelect = ref(0);
const SelectElement = ref(null);
const OptiontElement = ref([]);
const ShowSelect = ref(false);

function searchPengguna(value) {

    if (value.length > 0) {
        axios.get(route('api.orangtua.getOrgTua', { search: value }))
            .then((response) => {
                if (response.status == 200) {
                    const element = response.data;
                    ShowSelect.value = true;

                    if (SelectElement.value) {
                        const childElements = SelectElement.value.childNodes
                        // loop through the child elements and remove them
                        while (childElements.length > 0) {
                            SelectElement.value.removeChild(childElements[0])
                        }
                    }


                    OptiontElement.value = [];
                    for (let i = 0; i < element.length; i++) {
                        const orgTua = element[i];
                        const Option = document.createElement('option');
                        Option.value = JSON.stringify(orgTua);
                        Option.innerText = orgTua.nama;
                        if (SelectElement.value) {
                            SelectElement.value.appendChild(Option);
                        }
                        OptiontElement.value[i] = Option;
                    }
                    // console.log(OptiontElement.value)

                }
            })
    } else {
        ShowSelect.value = false;

    }
}

function SelectChangeElement(event) {
    PJ.value = '';
    const Hasil =JSON.parse(event.target.value)
    Form.org_tua_id = Hasil.id;
    Form.nama_orang_tua = Hasil.nama;
    if (SelectElement.value) {
        const childElements = SelectElement.value.childNodes
        // loop through the child elements and remove them
        SelectElement.value.removeChild(childElements[0])
        if (childElements.length < 1) {
            changeSelect.value = 1;

        }
    }

}
onMounted(() => {
    watch(PJ, (value) => {
        searchPengguna(value)
    })

})

</script>

<template>

    <Head title="Form Siswa" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Form Tambah Siswa</h2>
        </template>

        <div class="py-4 relative box-content">
            <section class="p-6 bg-gray-100 text-gray-900">
                <form @submit.prevent="submit()" novalidate="" action=""
                    class="container flex flex-col mx-auto space-y-12">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Data Tambah Siswa</p>
                        <p class="text-xs">Tambah Data Siswa dengan Memilih Nama Orang Tua</p>
                    </div>
                    <div class=" bg-gray-100" v-if="roleToCheck('Admin')">
                        <p class="font-medium mb-2">Pilih Data Orang Tua</p>
                        <div class="w-full flex items-center justify-center gap-3 relative">
                            <label for="firstname" class="text-sm whitespace-nowrap">Cari Data Orang Tua</label>
                            <TextInput id="firstname" type="text" placeholder="Cari nama lengkap" v-model="PJ"
                                class="w-full text-gray-900 text-xs" />
                            <InputError :message="Form.errors.org_tua_id" />

                            <div class="w-full mx-auto absolute z-10 -bottom-24" v-if="PJ != ''">
                                <select id="countries" multiple ref="SelectElement"
                                    @change="SelectChangeElement($event)"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                </select>
                            </div>
                        </div>
                        <div class="col-span-full sm:col-span-3">
                            <label for="nama_orang_tua" class="text-sm">Nama Orang Tua</label>
                            <TextInput id="nama_orang_tua" readonly type="text" placeholder="nama lengkap" v-model="Form.nama_orang_tua"
                                class="w-full text-gray-900 text-sm" />
                        </div>
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
                                <label for="tempat_lahir" class="text-sm">Tempat Lahir</label>
                                <TextInput id="tempat_lahir" type="text" v-model="Form.tempat_lahir"
                                    class="w-full text-gray-900 text-sm" />
                                <InputError :message="Form.errors.tempat_lahir" />

                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="tgl_lahir" class="text-sm">Tanggal Lahir</label>
                                <TextInput id="tgl_lahir" type="date" v-model="Form.tgl_lahir"
                                    class="w-full text-gray-900 text-sm" />
                                <InputError :message="Form.errors.tgl_lahir" />

                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="jenkel" class="text-sm mb-8">Jenis Kelamin</label>

                                <div class="flex items-center gap-4">
                                    <div class="flex items-center">
                                        <input id="jenkel-1" type="radio" value="Laki-Laki" name="jenkel" v-model="Form.jenkel"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500  focus:ring-2 ">
                                        <label for="jenkel-1" class="ms-2 text-sm font-medium text-gray-900">Laki-Laki</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="jenkel-2" type="radio" value="Perempuan" name="jenkel" v-model="Form.jenkel"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500  focus:ring-2 ">
                                        <label for="jenkel-2" class="ms-2 text-sm font-medium text-gray-900">Perempuan</label>
                                    </div>
                                </div>

                                <InputError :message="Form.errors.jenkel" />

                            </div>
                        </div>
                        <PrimaryButton type="submit" class="col-span-full text-center">Simpan</PrimaryButton>
                        <slot name="close"/>
                    </fieldset>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
