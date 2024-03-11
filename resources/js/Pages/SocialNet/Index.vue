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
    import Checkbox from "@/Components/Checkbox.vue";

    const nameInput = ref(null);
    const modal = ref(false);
    const title = ref('Editar red social');
    const id = ref('');

    defineProps({
        socialNets: {
            type: Object,
            required: true
        }
    })

    const form = useForm({
        id: '',
        name:'',
        url:'',
        active:false
    })

    const openModal = (name, url, active, sId ) =>{
        modal.value = true;
        id.value = sId;
        form.reset();
        form.id = sId;
        form.name = name
        form.url = url
        form.active = active ? true : false

    }

    const closeModal = () =>{
        modal.value = false;
        form.reset();
    }

    const save = () =>{
        form.put(route('socialnet.update',id.value),{
            onSuccess: () => {ok('Actualizado satisfactoriamente!')}
        });
    }
    const ok = (msj) =>{
        form.reset();
        closeModal();

        Swal.fire({title:msj,icon:'success'});
    }

</script>

<template>
    <AppLayout title="Red Social">
        <template #header>
            <h1 class="py-2 font-semibold text-xl text-gray-800 leading-tight">Red Social</h1>
        </template>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg: px-8">
                <div class="relative overflow-x-auto shadow-md sm:rounded-sm">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Url
                            </th>
                            <th scope="col" class="px-6 py-3">
                                activo
                            </th>
                            <th>
                                Acciones
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr :key="u.id" v-for="u in socialNets" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ u.name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ u.url }}
                            </td>
                            <td class="px-6 py-4">
                                {{ u.active ? `si` : `No` }}
                            </td>
                            <td class="px-6 py-4">
                                <WarningButton v-if="$page.props.user.permissions.includes('Update social net')"
                                    @click="openModal(u.name,u.url, u.active, u.id)">
                                    <i class="fa-solid fa-edit"></i>
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
                <InputLabel for="name" value="Nombre:"></InputLabel>
                <TextInput id="name" ref="nameInput"
                           v-model="form.name" type="text" class="mt-1 block w-3/4"
                           placeholder="Nombre"></TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="url" value="url:"></InputLabel>
                <TextInput id="url"
                           v-model="form.url" type="text" class="mt-1 block w-3/4"
                           placeholder="Url"></TextInput>
                <InputError :message="form.errors.url" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="active" value="Activar:"></InputLabel>
                <Checkbox v-model="form.active" :checked="form.active" class="mt-1" />
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
