<script>
    export default {
        name: "UserIndex"
    }
</script>
<script setup>
    import AppLayout from "@/Layouts/AppLayout.vue"
    import {Link, router, useForm} from "@inertiajs/vue3"

    import DangerButton from '@/Components/DangerButton.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import SelectInput from '@/Components/SelectInput.vue';
    import WarningButton from '@/Components/WarningButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import Modal from '@/Components/Modal.vue';
    import Swal from 'sweetalert2';
    import VueTailwindPagination from '@ocrv/vue-tailwind-pagination';
    import { ref } from 'vue';
    import Checkbox from "@/Components/Checkbox.vue";

    const nameInput = ref(null);
    const modal = ref(false);
    const title = ref('');
    const operation = ref(1);
    const id = ref('');

    defineProps({
        users: {
            type: Object,
            required: true
        },
        roles: {
            type: Object
        },
        url_photo: {
            type: String
        }
    })

    const form = useForm({
        id: '',
        name:'',
        lastname:'',
        phone:'',
        email:'',
        role_id:''
    })

    let formPage = useForm({});

    const onPageClick = (event)=>{
        formPage.get(route('users.index', { page: event }));
    }

    const openModal = (op ,name, lastname, email, phone, user, role ) =>{
        modal.value = true;
        operation.value = op;
        id.value = user;
        if(op == 1){
            form.reset();
            title.value = 'Crear usuario';
        }
        else{
            title.value = 'Editar usuario';
            form.id = user;
            form.name = name;
            form.lastname = lastname;
            form.email = email;
            form.phone = phone;
            form.role_id = role;
        }
    }

    const closeModal = () =>{
        modal.value = false;
        form.reset();
    }

    const save = () =>{
        if(operation.value == 1){

            form.post(route('users.store'),{
                onSuccess: () => {ok('Usuario creado satisfactoriamente!')},
                errorBag: 'ErrorUser'
            });
        }
        else{
            form.put(route('users.update',id.value),{
                onSuccess: () => {ok('Usuario actualizado satisfactoriamente!')}
            });
        }
    }
    const ok = (msj) =>{
        form.reset();
        closeModal();

        Swal.fire({title:msj,icon:'success'});
    }

    const deleteEmployee = (id, name) => {
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
                form.put(route('user.delete', id.value), {
                    onSuccess: () => {
                        ok('Usuario eliminado!')
                    }
                });
            }
        });
    }

    const formCheck = useForm({
        id: '',
        active: ''
    });

    const estado = (id) =>{
        formCheck.post(route('users.active', id));
    }


</script>

<template>
    <AppLayout title="Usuarios">
        <template #header>
            <h1 class="py-2 font-semibold text-xl text-gray-800 leading-tight">Usuarios</h1>
        </template>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg: px-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between">
                        <PrimaryButton @click="openModal(1)">
                            <i class="fa-solid fa-plus-circle"></i> Crear usuario
                        </PrimaryButton>
                    </div>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-sm">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Apellidos
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Correo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Teléfono
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Foto
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Role
                            </th>
                            <th>
                                Acciones
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr :key="u.id" v-for="u in users.data" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ u.name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ u.lastname }}
                            </td>
                            <td class="px-6 py-4">
                                {{ u.email }}
                            </td>
                            <td class="px-6 py-4">
                                {{ u.phone }}
                            </td>
                            <td class="px-6 py-4">
<!--                                <img v-if="u.profile_photo_path" class="h-8 w-8 rounded-full object-cover" :src="url_photo+'/'+ u.profile_photo_path ?? 'default_avatar.webp'" :alt="u.name">-->
                                <img v-if="u.profile_photo_path" class="h-8 w-8 rounded-full object-cover" :src="`${url_photo}${u.profile_photo_path}`" :alt="u.name">
                                <img v-if="!u.profile_photo_path" class="h-8 w-8 rounded-full object-cover" :src="`${url_photo}default_avatar.webp`" :alt="u.name">
                            </td>
                            <td class="px-6 py-4">
                                <Checkbox v-if="$page.props.user.permissions.includes('Status user')" :checked="u.active == true" @click="estado(u.id)" />
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-auto" v-for="(role, index) in u.roles" :key="index">
                                    <div class="py-2 px-3 rounded-full text-white bg-green-500">{{ role.name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <WarningButton v-if="$page.props.user.permissions.includes('Update user')"
                                    @click="openModal(2,u.name,u.lastname,u.email,u.phone,u.id,u.roles[0].id)">
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <VueTailwindPagination
                    :current="users.currentPage" :total="users.total"
                    :per-page="users.perPage"
                    @page-changed="onPageClick($event)"
                ></VueTailwindPagination>
            </div>
        </div>

        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium text-hray-900">{{ title }}</h2>
            <div class="p-3">
                <InputLabel for="name" value="Nombre:"></InputLabel>
                <TextInput id="name" ref="nameInput"
                           v-model="form.name" type="text" class="mt-1 block w-3/4"
                           placeholder="Name"></TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="lastname" value="Apellidos:"></InputLabel>
                <TextInput id="lastname"
                           v-model="form.lastname" type="text" class="mt-1 block w-3/4"
                           placeholder="Apellidos"></TextInput>
                <InputError :message="form.errors.lastname" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="email" value="Correo:"></InputLabel>
                <TextInput id="email"
                           v-model="form.email" type="text" class="mt-1 block w-3/4"
                           placeholder="Email"></TextInput>
                <InputError :message="form.errors.email" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="phone" value="Teléfono:"></InputLabel>
                <TextInput id="phone"
                           v-model="form.phone" type="text" class="mt-1 block w-3/4"
                           ></TextInput>
                <InputError :message="form.errors.phone" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="role_id" value="Role:"></InputLabel>
                <SelectInput id="role_id" :options="roles"
                             v-model="form.role_id" type="text" class="mt-1 block w-3/4"
                ></SelectInput>
                <InputError :message="form.errors.role_id" class="mt-2"></InputError>
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
