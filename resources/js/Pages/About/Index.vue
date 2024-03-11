<script setup>
    import AppLayout from "@/Layouts/AppLayout.vue"
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import WarningButton from '@/Components/WarningButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import Modal from '@/Components/Modal.vue';
    import { useForm } from "@inertiajs/vue3";
    import Swal from 'sweetalert2';
    import { ref } from 'vue';
    import DangerButton from "@/Components/DangerButton.vue";

    const nameInput = ref(null);
    const modal = ref(false);
    const title = ref('');
    const operation = ref(1);
    const id = ref('');

    defineProps({
        abouts: {
            type: Object,
            required: true
        }
    })

    const form = useForm({
        id: '',
        title:'',
        content:''
    })

    const openModal = (op ,titulo, content, sId ) =>{
        modal.value = true;
        operation.value = op;
        id.value = sId;
        if(op == 1){
            form.reset();
            title.value = 'Crear about';
        }
        else{
            title.value = 'Editar about';
            form.id = sId;
            form.title = titulo;
            form.content = content;
        }
    }

    const closeModal = () =>{
        modal.value = false;
        form.reset();
    }

    const save = () =>{
        if(operation.value == 1){

            form.post(route('about.store'), {
                onSuccess: () => {
                    ok('Creado satisfactoriamente!')
                },
                errorBag: 'ErrorUser'
            })
        }
        else{
            form.put(route('about.update',id.value),{
                onSuccess: () => {ok('Actualizado satisfactoriamente!')}
            });
        }
    }
    const ok = (msj) =>{
        form.reset();
        closeModal();

        Swal.fire({title:msj,icon:'success'});
    }

    const deleteAbout = (Sid, name) => {
        id.value = Sid
        const alerta = Swal.mixin({
            buttonsStyling: true
        });
        alerta.fire({
            title: `Are you sure delete ${name}?`,
            icon: 'question', showCancelButton: true,
            confirmButtonText: '<i class="fa-solid fa-check"></i> Si, eliminado',
            cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.delete(route('about.destroy', id.value), {
                    onSuccess: () => {
                        ok('Se ha eliminado satisfactoriamente!')
                    }
                });
            }
        });
    }
</script>

<template>
    <AppLayout title="About">
        <template #header>
            <h1 class="py-2 font-semibold text-xl text-gray-800 leading-tight">About</h1>
        </template>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg: px-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between">
                        <PrimaryButton @click="openModal(1)">
                            <i class="fa-solid fa-plus-circle"></i> About
                        </PrimaryButton>
                    </div>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-sm">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                titulo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Contenido
                            </th>
                            <th>
                                Acciones
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr :key="u.id" v-for="u in abouts" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ u.title }}
                            </th>
                            <td class="px-6 py-4">
                                {{ u.content }}
                            </td>
                            <td class="px-6 py-4">
                                <WarningButton v-if="$page.props.user.permissions.includes('Update about')"
                                    @click="openModal(2,u.title,u.content, u.id)">
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                                <DangerButton v-if="$page.props.user.permissions.includes('Destroy about')" @click="deleteAbout(u.id, u.title)" class="mx-2">
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
                <InputLabel for="title" value="Titulo:"></InputLabel>
                <TextInput id="title" ref="nameInput"
                           v-model="form.title" type="text" class="mt-1 block w-3/4"
                           placeholder="Titulo"></TextInput>
                <InputError :message="form.errors.title" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="content" value="Contentido:"></InputLabel>
                <TextInput id="content"
                           v-model="form.content" type="text" class="mt-1 block w-3/4"
                           placeholder="Contenido"></TextInput>
                <InputError :message="form.errors.content" class="mt-2"></InputError>
            </div>
            <div class="p-3 mt-6">
                <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i> Guardar
                </PrimaryButton>
            </div>
            <div class="p-3 mt-6 flex justify-end">
                <SecondaryButton class="ml-3"
                                 @click="closeModal">
                    Cancelar
                </SecondaryButton>
            </div>
        </Modal>
    </AppLayout>


</template>

<style scoped>

</style>
