<script>
export default {
    name: "TestimonialIndex"
};
</script>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import WarningButton from "@/Components/WarningButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import {router, useForm} from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { ref } from "vue"
import Swal from "sweetalert2";

const nameInput = ref(null)
const contentInput = ref(null)
const modal = ref(false)
const title = ref('')
const operation = ref(1)
const id = ref('')



defineProps({
    testimonials: {
        type: Object,
        required: true
    },
    url_testimonial: {
        type: String,
        required: true
    }
})

const form = useForm({
    id: '',
    name: null,
    occupation: null,
    content: null,
    image: null
})

const openModal = (op, name, occupation, content,  image, sId) => {
    modal.value = true
    operation.value = op
    id.value = sId

    if(op == 1){
        form.reset()
        title.value = 'Crear testimonio'
    }else {
        title.value = 'Editar testimonio'
        form.id = sId
        form.name = name
        form.occupation = occupation
        form.content = content
    }
}

const closeModal = () =>{
    modal.value = false;
    form.reset();
}

const save = () =>{
    if (operation.value == 1){

        form.post(route('testimonial.store'), {
            onSuccess: () =>{ ok('El Testimonio ha sido creado satisfactoriamente!') },
            errorBag: 'Error 500',
            forceFormData: true,
            method: "POST",
            onError: (errors) =>{
                if(errors.name){
                    Swal.fire({title:errors.name,icon:'error'});
                    return;
                }
                if(errors.content){
                    Swal.fire({title:errors.ocupation,icon:'error'});
                    return;
                }
                if(errors.ocupation){
                    Swal.fire({title:errors.content,icon:'error'});
                    return;
                }
                if(errors.image){
                    Swal.fire({title:errors.image,icon:'error'});
                    return;
                }

            }
        })
    }else{
        form.post(route('testimonial.update', form.id), {
            onSuccess: () => { ok('El Testimonio se ha actualizado satisfactoriamente!') },
            errorBag: 'Error 500',
            forceFormData: true,
        })
    }
}

const ok = (msj) =>{
    form.reset();
    closeModal();

    Swal.fire({title:msj,icon:'success'});
}

const deleteTestimonial = (sId, name) => {
    id.value = sId
    const alert = Swal.mixin({
        buttonsStyling: true
    });
    alert.fire({
        title: `Vas a eliminar ${name}?`,
        icon: 'question', showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Si, eliminado',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('testimonial.destroy', id.value), {
                onSuccess: () => {
                    ok('El testimonio ha sido eliminado satisfactoriamente!')
                }
            });
        }
    });
}

</script>

<template>
    <AppLayout title="Testimonio">
        <template #header>
            <h1 class="py-2 font-semibold text-xl text-gray-800 leading-tight">Testimonio</h1>
        </template>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg: px-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between">
                        <PrimaryButton @click="openModal(1)">
                            <i class="fa-solid fa-plus-circle"></i> Crear testimonio
                        </PrimaryButton>
                    </div>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-sm">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3">Nombre</th>
                            <th class="px-6 py-3">Ocupación</th>
                            <th class="px-6 py-3">Contenido</th>
                            <th class="px-6 py-3">Imagen</th>
                            <th class="px-6 py-3">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(s, index) in testimonials" :key="index">
                            <td class="px-6 py-4">{{ s.name }}</td>
                            <td class="px-6 py-4">{{ s.occupation }}</td>
                            <td class="px-6 py-4">{{ s.content }}</td>
                            <td class="px-6 py-4">
                                <img class="w-1/12 border-b-2 rounded" :src="`${url_testimonial}${s.image}`" :alt="s.name">
                            </td>
                            <td>
                                <WarningButton @click="openModal(2, s.name, s.occupation, s.content, s.image, s.id)">
                                    <i class="fa fa-edit"></i>
                                </WarningButton>
                                <DangerButton v-if="$page.props.user.permissions.includes('Destroy testimonial')" @click="deleteTestimonial(s.id, s.name)" class="mx-2">
                                    <i class="fa fa-trash"></i>
                                </DangerButton>
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
                <InputLabel for="name" value="Name:"></InputLabel>
                <TextInput id="name" ref="nameInput"
                           v-model="form.name" type="text" class="mt-1 block w-3/4"
                           placeholder="Name"></TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>
            <div class="p-3">
              <InputLabel for="ocupation" value="Ocupación:"></InputLabel>
              <TextInput id="ocupation"
                         v-model="form.occupation" type="text" class="mt-1 block w-3/4"
                         placeholder="Ocupación"></TextInput>
              <InputError :message="form.errors.occupation" class="mt-2"></InputError>
            </div>
            <div class="p-3">
              <InputLabel for="content" value="Contenido:"></InputLabel>
              <TextInput id="content" ref="contentInput"
                         v-model="form.content" type="text" class="mt-1 block w-3/4"
                         placeholder="Contenido"></TextInput>
              <InputError :message="form.errors.content" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="imagen" value="Imagen:"></InputLabel>
                <input id="imagen" class="mt-1 block w-3/4" type="file" @input="form.image = $event.target.files[0]" />
                <InputError :message="form.errors.image" class="mt-2"></InputError>
            </div>
            <div class="mt-2 w-full pt-2">
                <progress class="w-full text-white" v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                </progress>
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
