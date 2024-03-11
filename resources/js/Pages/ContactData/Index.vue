<script setup>
    import TextInput from "@/Components/TextInput.vue";
    import SecondaryButton from "@/Components/SecondaryButton.vue";
    import PrimaryButton from "@/Components/PrimaryButton.vue";
    import InputError from "@/Components/InputError.vue";
    import AppLayout from "@/Layouts/AppLayout.vue";
    import WarningButton from "@/Components/WarningButton.vue";
    import InputLabel from "@/Components/InputLabel.vue";
    import Swal from "sweetalert2";
    import {useForm} from "@inertiajs/vue3";
    import Modal from '@/Components/Modal.vue';
    import { ref } from 'vue';

    const props = defineProps({
        contactDatas: {
            type: Object,
            required: true
        }
    })

    const modal = ref(false)
    const id = ref('');


    const form = useForm({
        id: '',
        email: null,
        address: null,
        phone: null
    })

    const openModal = (email, address, phone, sId) => {
        modal.value = true
        id.value = sId
        form.id = sId
        form.email = email
        form.address = address
        form.phone = phone
    }

    const closeModal = () =>{
        modal.value = false;
        form.reset();
    }

    const save = () =>{
        form.post(route('contactdata.update', form.id), {
            onSuccess: () => { ok('actualizado satisfactoriamente!') },
            errorBag: 'Error 500',
            forceFormData: true,
        })
    }

    const ok = (msj) =>{
        form.reset();
        closeModal();

        Swal.fire({title:msj,icon:'success'});
    }
</script>

<template>
    <AppLayout title="Datos de contactos">
        <template #header>
            <h1 class="py-2 font-semibold text-xl text-gray-800 leading-tight">Datos de Contactos</h1>
        </template>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg: px-8">
                <div class="relative overflow-x-auto shadow-md sm:rounded-sm">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3">Correo</th>
                            <th class="px-6 py-3">Dirección</th>
                            <th class="px-6 py-3">Telefono</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(s, index) in contactDatas" :key="index">
                            <td class="px-6 py-4">{{ s.email }}</td>
                            <td class="px-6 py-4">{{ s.address }}</td>
                            <td class="px-6 py-4">{{ s.phone }}</td>
                            <td>
                                <WarningButton @click="openModal(s.email, s.address, s.phone, s.id)">
                                    <i class="fa fa-edit"></i>
                                </WarningButton>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium text-hray-900">{{ title }}</h2>
            <div class="p-3">
                <InputLabel for="title" value="Correo:"></InputLabel>
                <TextInput id="title" ref="nameInput"
                           v-model="form.email" type="text" class="mt-1 block w-3/4"
                           placeholder="Titulo"></TextInput>
                <InputError :message="form.errors.email" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="content" value="Dirección:"></InputLabel>
                <TextInput id="content" ref="contentInput"
                           v-model="form.address" type="text" class="mt-1 block w-3/4"
                           placeholder="Contenido"></TextInput>
                <InputError :message="form.errors.address" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="content" value="Telefono:"></InputLabel>
                <TextInput id="content" ref="contentInput"
                           v-model="form.phone" type="text" class="mt-1 block w-3/4"
                           placeholder="Contenido"></TextInput>
                <InputError :message="form.errors.phone" class="mt-2"></InputError>
            </div>
            <div class="p-3 mt-6">
                <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i> Guardar
                </PrimaryButton>
            </div>
            <div class="p-3 mt-6 flex justify-end">
                <SecondaryButton class="ml-3" @click="closeModal">
                    Cancelar
                </SecondaryButton>
            </div>
        </Modal>
    </AppLayout>
</template>

<style scoped>

</style>
