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

const props = defineProps({
    informasi: {
        type: Object,
        default: () => ({})
    }
})
const Form = useForm({
    nama_informasi: props.informasi != null ? props.informasi.nama_informasi : 'PAUD INSAN MASAGENA',
    nip: props.informasi != null ? props.informasi.nip : '',
    kepala_informasi: props.informasi != null ? props.informasi.kepala_informasi : '',
    foto_profile:'',
    alamat: props.informasi != null ? props.informasi.alamat : 'Jalan Hertasning Bok E10 Noor 11 RT/RW 00/006 Kelurahan Tidung',
    logo: '',
    visi: props.informasi != null ? props.informasi.visi : '',
    misi: props.informasi != null ? props.informasi.misi : '',
    deskripsi: props.informasi != null ? props.informasi.deskripsi : '',
})

function submit() {
    Form.post(route('Setting.store'), {
        onError: (err) => {
            console.log(err)
        },
        forceFormData: true,
    });
}
const EditorOptions = ref({
    modules: {

    },
    placeholder: 'Compose an epic...',
    readOnly: false,
    theme: 'snow'

})

</script>

<template>

    <Head title="PAUD INSAN MASAGENA" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Form Informasi PAUD INSAN MASAGENA</h2>
        </template>

        <div class="py-4 relative box-content">
            <section class="p-6 bg-gray-100 text-gray-900">
                <form @submit.prevent="submit()" novalidate="" action="" enctype="multipart/form-data"
                    class="container flex flex-col mx-auto space-y-12">
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full sm:col-span-3">
                                <label for="nama_informasi" class="text-sm capitalize">Nama PAUD INSAN MASAGENA</label>
                                <TextInput id="nama_informasi" type="text" placeholder="nama PAUD INSAN MASAGENA"
                                    v-model="Form.nama_informasi" class="w-full text-gray-900" />
                                <InputError :message="Form.errors.nama_informasi" />
                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="alamat" class="text-sm capitalize">Alamat</label>
                                <TextInput id="alamat" type="text" v-model="Form.alamat" placeholder="alamat..."
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.alamat" />

                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="kepala_informasi" class="text-sm capitalize">Kepala PAUD INSAN MASAGENA</label>
                                <TextInput id="kepala_informasi" type="text" v-model="Form.kepala_informasi"
                                    placeholder="Kepala PAUD INSAN MASAGENA" class="w-full text-gray-900" />
                                <InputError :message="Form.errors.kepala_informasi" />

                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="nip" class="text-sm capitalize">Nip Kepala PAUD INSAN MASAGENA</label>
                                <TextInput id="nip" type="number" v-model="Form.nip" placeholder="Nip"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.nip" />

                            </div>

                            <div class="col-span-full">
                                <label for="photo" class="block text-sm font-medium leading-6 text-gray-900">Foto
                                    Profil Kepala
                                    PAUD INSAN MASAGENA</label>
                                <div class="mt-2 flex items-center gap-x-3">
                                    <svg class="h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor"
                                        aria-hidden="true" v-if="informasi == null">
                                        <path fill-rule="evenodd"
                                            d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <img v-else :src="informasi.profile_url" class="w-12 object-scale-down rounded-full" alt="Foto Profile">
                                    <input type="file" class="" @input="Form.foto_profile = $event.target.files[0]">
                                    <!-- <button type="button"
                                        class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Change</button> -->
                                </div>
                                <InputError :message="Form.errors.foto_profile" />

                            </div>
                            <div class="col-span-full">
                                <label for="photo" class="block text-sm font-medium leading-6 text-gray-900">Logo
                                    PAUD INSAN MASAGENA</label>
                                <div class="mt-2 flex items-center gap-x-3">
                                    <svg class="h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor"
                                        aria-hidden="true" v-if="informasi == null">
                                        <path fill-rule="evenodd"
                                            d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <img v-else :src="informasi.logo_url" class="w-12 object-scale-down rounded-full" alt="Foto Profile">
                                    <input type="file" class="" @input="Form.logo = $event.target.files[0]">
                                    <!-- <button type="button"
                                        class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Change</button> -->
                                </div>
                                <InputError :message="Form.errors.logo" />

                            </div>

                            <div class="col-span-full">
                                <label for="visi" class="text-sm capitalize">visi</label>
                                <quill-editor id="visi" contentType="html" theme="snow" v-model:content="Form.visi"
                                    :options="EditorOptions" placeholder="@visi PAUD INSAN MASAGENA"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.visi" />


                            </div>
                            <div class="col-span-full mb-24 mt-32 sm:mb-16 sm:mt-20">
                                <label for="misi" class="text-sm capitalize">misi</label>
                                <quill-editor id="misi" contentType="html" theme="snow" v-model:content="Form.misi"
                                    :options="EditorOptions" placeholder="@misi PAUD INSAN MASAGENA"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.misi" />


                            </div>
                            <div class="col-span-full mb-28 sm:mb-20 mt-5">
                                <label for="deskripsi" class="text-sm capitalize">deskripsi</label>
                                <quill-editor id="deskripsi" contentType="html" theme="snow" :options="EditorOptions"
                                    v-model:content="Form.deskripsi" placeholder="@deskripsi/Sejarah PAUD INSAN MASAGENA"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.deskripsi" />


                            </div>
                        </div>
                        <PrimaryButton type="submit" class="col-span-full text-center">Simpan</PrimaryButton>
                    </fieldset>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.ql-editor[contenteditable=false] {
    background-color: white;
}
.ql-editor[contenteditable=true] {
    background-color: white;
}
</style>
