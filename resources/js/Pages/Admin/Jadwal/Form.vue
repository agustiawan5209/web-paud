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

})
const Form = useForm({
    usia: '',
    tanggal: '',
    jenis_imunisasi: '',
    deskripsi: '',
    penanggung_jawab: '',
})

function submit() {
    Form.post(route('Jadwal.store'), {
        onError: (err) => {
            console.log(err)
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
        axios.get(route('data.user.getUser', { search: value }))
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
                        const User = element[i];
                        const Option = document.createElement('option');
                        Option.value = User.name;
                        Option.innerText = User.name;
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
    PJ.value = event.target.value;
    Form.penanggung_jawab = event.target.value;
    if (SelectElement.value) {
        const childElements = SelectElement.value.childNodes
        // loop through the child elements and remove them
        console.log(childElements.length)
        SelectElement.value.removeChild(childElements[0])
        if (childElements.length < 1) {
            changeSelect.value = 1;

        }
    }

}
onMounted(() => {
    // watch(PJ, (value) => {
    //     searchPengguna(value)
    // })

})

const JenisImunisasi = ref([
    'Vitamin A - 1',
    'Vitamin A - 2',
    'Oralit',
    'BH (NOL)',
    'BCG',
    'POLIO - 1',
    'POLIO - 2',
    'POLIO - 3',
    'DPT/HB - 1',
    'DPT/HB - 2',
    'DPT/HB - 3',
    'Campak',
]);

</script>

<template>

    <Head title="Jadwal Imunisasi" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Form Tambah Jadwal Imunisasi</h2>
        </template>

        <div class="py-4 relative box-content">
            <section class="p-6 bg-gray-100 text-gray-900">
                <form @submit.prevent="submit()" novalidate="" action=""
                    class="container flex flex-col mx-auto space-y-12">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Data Informasi Jadwal Imunisasi</p>
                        <p class="text-xs">Tambahkan data pegawai/staff dari puskesmas</p>
                    </div>
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50 relative box-content">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full sm:col-span-3">
                                <label for="usia" class="text-sm">Usia</label>
                                <TextInput id="usia" type="text" placeholder="0 - 5 Tahun" v-model="Form.usia"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.usia" />
                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="jenis_imunisasi" class="text-sm">Jenis Imunisasi</label>
                                <select id="jenis_imunisasi" v-model="Form.jenis_imunisasi"
                                    class="w-full border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm text-black">
                                    <option value="">---</option>
                                    <option v-for="(item, key) in JenisImunisasi" :value="item" class="text-black">
                                        {{ item }}
                                    </option>
                                </select>
                                <InputError :message="Form.errors.jenis_imunisasi" />

                            </div>
                            <div class="col-span-full sm:col-span-2">
                                <label for="tanggal" class="text-sm">Tanggal</label>
                                <TextInput id="tanggal" type="date" v-model="Form.tanggal" placeholder="tanggal..."
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.tanggal" />

                            </div>

                            <div class="col-span-full sm:col-span-2 relative">
                                <label for="penanggung_jawab" class="text-sm">Penanggung Jawab</label>
                                <TextInput id="penanggung_jawab" type="text" placeholder="Penanggung Jawab"
                                    v-model="Form.penanggung_jawab" class="w-full text-gray-900" />

                                <div class="w-full mx-auto absolute z-10 -bottom-24" v-if="ShowSelect">
                                    <select id="countries" multiple ref="SelectElement"
                                        @change="SelectChangeElement($event)"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                    </select>
                                </div>

                                <InputError :message="Form.errors.penanggung_jawab" />
                            </div>

                            <div class="col-span-full relative box-content">
                                <label for="deskripsi" class="text-sm">Deskripsi</label>
                                <quill-editor id="deskripsi" contentType="html" theme="snow"
                                    v-model:content="Form.deskripsi" placeholder="@deskripsi"
                                    class="w-full h-full text-gray-900 relative" />
                                <InputError :message="Form.errors.deskripsi" />

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
