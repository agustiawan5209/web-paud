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
    nama: '',
    kode: '',
})

function submit() {
    Form.post(route('Kelas.store'), {
        onError: (err) => {
            console.log(err)
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
                        <p class="font-medium">Data Informasi Kelas</p>
                        <p class="text-xs">Tambahkan data</p>
                    </div>
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50 relative box-content">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full sm:col-span-3">
                                <label for="kode" class="text-sm">kode Kelas</label>
                                <TextInput id="kode" type="text" placeholder="..............." v-model="Form.kode"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.kode" />

                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="nama" class="text-sm">Nama Kelas</label>
                                <TextInput id="nama" type="text" placeholder="..............." v-model="Form.nama"
                                    class="w-full text-gray-900" />
                                <InputError :message="Form.errors.nama" />
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
