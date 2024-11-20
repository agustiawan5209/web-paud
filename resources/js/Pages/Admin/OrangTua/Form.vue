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

})
const Form = useForm({
    name:'',
    alamat:'',
    nama_ayah:'',
    alamat_ayah:'',
    no_telpon_ayah:'',
    no_telpon:'',
    username:'',
    email:'',
    password:'',
})

function submit() {
    Form.post(route('OrangTua.store'), {
        onError: (err) => {
            console.log(err)
        }
    });
}


</script>

<template>

    <Head title="Orang Tua" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Form Tambah Orang Tua</h2>
        </template>

        <div class="py-4 relative box-content">
            <section class="p-6 bg-gray-100 text-gray-900">
                <form @submit.prevent="submit()" novalidate="" action="" class="container flex flex-col mx-auto space-y-12">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Data Informasi Orang Tua</p>
                        <p class="text-xs">Tambahkan data Guru </p>
                    </div>
                    <fieldset class="grid grid-cols-3 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                            <div class="col-span-full sm:col-span-3">
                                <label for="firstname" class="text-sm">Nama Lengkap Ibu</label>
                                <TextInput id="firstname" type="text" placeholder="nama lengkap" v-model="Form.name"  class="w-full text-gray-900"  />
                                <InputError :message="Form.errors.name"/>
                            </div>

                            <div class="col-span-full sm:col-span-3">
                                <label for="alamat" class="text-sm">Alamat Ibu</label>
                                <TextInput id="alamat" type="text" v-model="Form.alamat" placeholder="alamat..." class="w-full text-gray-900"  />
                                <InputError :message="Form.errors.alamat"/>

                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="nama_ayah" class="text-sm">Nama Lengkap Ayah</label>
                                <TextInput id="nama_ayah" type="text" placeholder="nama lengkap" v-model="Form.nama_ayah"  class="w-full text-gray-900"  />
                                <InputError :message="Form.errors.nama_ayah"/>
                            </div>

                            <div class="col-span-full sm:col-span-3">
                                <label for="alamat_ayah" class="text-sm">Alamat Ayah</label>
                                <TextInput id="alamat_ayah" type="text" v-model="Form.alamat_ayah" placeholder="alamat..." class="w-full text-gray-900"  />
                                <InputError :message="Form.errors.alamat_ayah"/>

                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="no_telpon" class="text-sm">No. Telepon</label>
                                <TextInput id="no_telpon" type="text" v-model="Form.no_telpon" placeholder="No. telpon" class="w-full text-gray-900"  />
                                <InputError :message="Form.errors.no_telpon"/>

                            </div>
                            <div class="col-span-full sm:col-span-3">
                                <label for="no_telpon_ayah" class="text-sm">No. Telepon Ayah</label>
                                <TextInput id="no_telpon_ayah" type="text" v-model="Form.no_telpon_ayah" placeholder="No. telpon" class="w-full text-gray-900"  />
                                <InputError :message="Form.errors.no_telpon_ayah"/>

                            </div>
                            <div class="space-y-2 col-span-full">
                                <p class="font-medium">Data Pengguna</p>
                                <p class="text-xs">Digunakan Untuk Masuk/Login Ke dalam Sistem</p>
                            </div>
                            <div class="col-span-full sm:col-span-2">
                                <label for="username" class="text-sm">username</label>
                                <TextInput id="username" type="text" v-model="Form.username" placeholder="@username" class="w-full text-gray-900"  />
                                <InputError :message="Form.errors.username"/>

                            </div>
                            <div class="col-span-full sm:col-span-2">
                                <label for="state" class="text-sm">Password</label>
                                <TextInput id="state" type="text" placeholder="" v-model="Form.password" class="w-full text-gray-900"  />
                                <InputError :message="Form.errors.password"/>

                            </div>
                            <div class="col-span-full sm:col-span-2">
                                <label for="email" class="text-sm">Email</label>
                                <TextInput id="email" type="email" placeholder="" v-model="Form.email" class="w-full text-gray-900"  />
                                <InputError :message="Form.errors.email"/>
                            </div>
                        </div>
                        <PrimaryButton type="submit" class="col-span-full text-center">Simpan</PrimaryButton>
                    </fieldset>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
