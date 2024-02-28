<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import {useForm} from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import {ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import WarningButton from "@/Components/WarningButton.vue";
import SelectInput from "@/Components/SelectInput.vue";

defineProps({
    rolesPermissions: {
        type: Object,
        required: true
    },
    permissions: {
        type: Object,
        required: true
    }
})
const modal = ref(false)
const operation = ref(1)
const title = ref('')
const id = ref('')

const openModal = (op, titleModal) => {
    operation.value = op
    if (op == 1) {
        title.value = `Crear permisos ${titleModal}`
    } else {
        title.value = `Editar permisos ${titleModal}`
    }
    modal.value = true
}

const closeModal = () => {
    modal.value = false;
}

</script>

<template>
    <AppLayout title="Roles">
        <template #header>
            <h1 class="py-2 font-semibold text-xl text-gray-800 leading-tight">Roles</h1>
        </template>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg: px-8">
                <div class="relative overflow-x-auto shadow-md sm:rounded-sm">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3">Nivel de roles</th>
                            <th class="px-6 py-3">Permisos</th>
                            <th class="px-6 py-3">Editar Permisos</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(role, index) in rolesPermissions" :key="index">
                            <td class="px-6 py-3">{{ role.name }}</td>
                            <td class="px-6 py-3">
                                <ul v-for="(p, index) in role.permissions" :key="index">
                                    <li>{{ p.name }}</li>
                                </ul>
                            </td>
                            <td class="px-6 py-3">
                                <WarningButton @click="openModal(2, role.name)">
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
