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
    jabatan: {
        type: Object,
        default: () => ({})
    },
    colums: {
        type: Object,
        default: () => ({})
    },
    linkCreate: {
        type: String,
        default: '',
    },
})

const columsReplace = (value) => {
    return value.replace(/_/g, ' ');
}
const dataForm = new Object;

props.colums.forEach(element => {
    dataForm[element] = ''
});
const Form = useForm(dataForm)

function submit() {
    Form.post(route(props.linkCreate), {
        onError: (err) => {
            console.log(err)
        }
    });
}

function isObject(variabel) {
    if ((variabel instanceof Object)) {
        return true;
    } else {
        false;
    }
}
</script>

<template>

    <Head title="Guru" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Form Tambah Guru</h2>
        </template>

        <div class="py-4 relative box-content">
            <section class="p-6 bg-gray-100 text-gray-900">
                <form @submit.prevent="submit()" novalidate="" action=""
                    class="container flex flex-col mx-auto space-y-12">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Data Informasi Guru</p>
                        <p class="text-xs">Tambahkan data Guru </p>
                    </div>
                    <fieldset class="grid grid-cols-6 gap-6 p-6 rounded-md shadow-sm bg-gray-50">
                        <template v-for="(item, index) in colums" :key="index">
                            <div class="col-span-full" :class="index == 'alamat' ? 'col-span-full' : 'sm:col-span-3'">

                                <label :for="index" class="text-sm capitalize" v-if="isObject(item)">{{ item.name }}
                                </label>
                                <label :for="index" class="text-sm capitalize" v-else>{{ columsReplace(item) }} </label>

                                <select name="jabatan" id="jabatan" v-if="isObject(item)" v-model="Form[item.name]"
                                    class="border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm w-full text-gray-900">
                                    <option value="">---</option>
                                    <option v-for="jab in item.value" :value="jab.name">{{ jab.name }}</option>
                                </select>

                                <TextInput :id="item" v-else v-model="Form[item]" type="text"
                                    :placeholder="columsReplace(item)" class="w-full text-gray-900" />


                                <InputError v-if="isObject(item)" :message="Form.errors[item.name]" />
                                <InputError :message="Form.errors[item]" />
                            </div>

                        </template>
                        <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                        </div>
                        <PrimaryButton type="submit" class="col-span-full text-center">Simpan</PrimaryButton>
                    </fieldset>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
