<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, defineProps, watch,inject, onMounted } from 'vue';
import Modal from '@/Components/Modal.vue';
const swal = inject("$swal")
const page = usePage();

const props = defineProps({
    siswa: {
        type: Object,
        default: () => ({})
    }
})



const Form = useForm({
    siswa_id: props.siswa.id,
    slug: null,
    respon: null
})

const varModal = ref(false)
const ShowModal = (id) => {
    varModal.value = true;
    Form.slug = id;
}

function submit() {
    Form.put(route('Org.Perkembangan.update'), {
        onError: (err) => {
            console.log(err);
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
        },
        onSuccess: () => {
            Form.reset('slug');
            swal({
                icon: "success",
                title: 'Berhasil',
                text: page.props.message,
                showConfirmButton: true,
                timer: 2000
            });
        }
    })
}
</script>

<template>

    <Head title="Laporan Perkembangan Harian" />


    <Modal :show="varModal">
        <form @submit.prevent="submit">
            <div class="p-4">
                <label for="respon" class="text-sm">Masukkan Pesan Ke Guru</label>
                <quill-editor id="respon" contentType="html" theme="snow"
                                                        v-model:content="Form.respon" placeholder="@deskripsi"
                                                        class="w-full text-gray-900" />
                <PrimaryButton type="submit" class="w-full mt-4 text-center">Kirim
                </PrimaryButton>
            </div>


        </form>
    </Modal>
    <AuthenticatedLayout>
        <template #header>
            <h2>Laporan Perkembangan Harian Siswa {{ siswa.nama }}</h2>
        </template>

        <div class="md:py-4 relative box-content">

            <section class=" py-2 px-0 md:px-6  md:py-6 bg-primary text-dark">
                <PrimaryButton type="button" onclick="history.back();return false;">Kembali</PrimaryButton>

                <div class="relative overflow-x-auto border shadow-md sm:rounded-lg mt-5">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <colgroup>
                            <col class="w-10">
                            <col class="w-60">
                            <col>
                        </colgroup>
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-2 py-3 border">
                                    No.
                                </th>
                                <th scope="col" class="px-6 py-3 border">
                                    Tanggal Laporan Harian
                                </th>
                                <th scope="col" class="px-6 py-3 border">
                                    Keterangan
                                </th>
                                <th scope="col" class="px-6 py-3 border">
                                    Respon
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in siswa.dataperkembangansiswa" :key="item.id"
                                class="odd:bg-white even:bg-gray-50 border-b">
                                <td scope="row" class="px-2 py-4 border ">
                                    {{ index + 1 }}
                                </td>
                                <td class="px-6 py-4 border">
                                    <span> {{ item.perkembangansiswa.tanggal }} </span>
                                </td>
                                <td class="px-6 py-4 border" v-html="item.perkembangan">
                                </td>

                                <td class="px-6 py-4 border">
                                    <PrimaryButton v-if="item.respon == null" type="button" @click="ShowModal(item.id)">Kirim Pesan Ke Guru</PrimaryButton>
                                    <span v-if="item.respon != null" v-html="item.respon"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
