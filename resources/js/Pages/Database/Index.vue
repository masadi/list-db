<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, reactive } from 'vue'
import { Head, router, Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import { FwbButton, FwbModal, FwbInput, FwbSelect, FwbDropdown, FwbToast } from 'flowbite-vue'

const isShowModal = ref(false)
function closeModal() {
    isShowModal.value = false
}
function showModal() {
    isShowModal.value = true
}
defineProps({
    data: Object,
    errors: Object
})
const params = ref({
    search: '',
    field: 'connection',
    direction: 'asc'
})
const form = reactive({
    id: '',
    connection: '',
    host: '',
    port: '',
    name: '',
    username: '',
    password: '',
})
const status = reactive({
    connection: '',
    host: '',
    port: '',
    name: '',
    username: '',
    password: '',
})
const error = reactive({
    connection: '',
    host: '',
    port: '',
    name: '',
    username: '',
    password: '',
})
const sort = (val) => {
    params.value.field = val
    params.value.direction = params.value.direction === 'asc' ? 'desc' : 'asc'
    console.log(val);
}
const submitModal = () => {
    router.post('/database/add', form, {
        onSuccess: (page) => {
            console.log(page);
            isShowModal.value = false
        },
        onError: (errors) => {
            console.log(errors);
            if (errors.detail.errors) {
                status.connection = (errors.detail.errors.connection) ? 'error' : 'success'
                status.host = (errors.detail.errors.host) ? 'error' : 'success'
                status.port = (errors.detail.errors.port) ? 'error' : 'success'
                status.name = (errors.detail.errors.name) ? 'error' : 'success'
                status.username = (errors.detail.errors.username) ? 'error' : 'success'
                status.password = (errors.detail.errors.password) ? 'error' : 'success'
                error.connection = errors.detail.errors.connection
                error.host = errors.detail.errors.host
                error.port = errors.detail.errors.port
                error.name = errors.detail.errors.name
                error.username = errors.detail.errors.username
                error.password = errors.detail.errors.password
            }
        },
    })
}
const editData = (data) => {
    console.log(data);
    isShowModal.value = true
    form.connection = data.connection
    form.host = data.host
    form.port = data.port
    form.name = data.name
    form.username = data.username
    form.password = data.password
}
const sukses = ref(false)
const gagal = ref(false)
const encrytPassword = (originalString) => {
    if(originalString){
        let startIndex = 2;
        let endIndex = originalString.length;
        let maskedString = originalString.substring(0, startIndex) +
            "*".repeat(endIndex - startIndex) +
            originalString.substring(endIndex);
        return maskedString;
    }
}
</script>

<template>

    <Head title="Database" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Database</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between">
                    <div class="mb-4 max-w-xs">
                        <input type="search" v-model="params.search" aria-label="Search" placeholder="Search..."
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    </div>
                    <div class="mb-4 max-w-xs">
                        <fwb-button @click="showModal">Add New</fwb-button>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed table-bordered table-striped">
                            <thead class="bg-indigo-500">
                                <tr>
                                    <template
                                        v-for="item in ['connection', 'host', 'port', 'name', 'username', 'password']">
                                        <th scope="col"
                                            class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                            <span class="inline-flex py-3 px-6 w-full justify-between"
                                                @click="sort(item)">{{ item }}
                                                <svg v-if="params.field === item && params.direction === 'asc'"
                                                    xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z" />
                                                </svg>
                                                <svg v-if="params.field === item && params.direction === 'desc'"
                                                    xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z" />
                                                </svg>
                                            </span>
                                        </th>
                                    </template>
                                    <th scope="col"
                                        class="text-xs font-semibold tracking-wider text-left text-white uppercase">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="(db, index) in data.data" :key="db.id">
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        {{ db.connection }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        {{ db.host }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        {{ db.port }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        {{ db.name }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        {{ db.username }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        {{ encrytPassword(db.password) }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <fwb-dropdown text="Action" align-to-end>
                                            <div class="w-52">
                                                <Link :href="`/database/detail/${db.id}`">
                                                <p class="p-2">Detail</p>
                                                </Link>
                                                <a href="javascript:void(0)" @click="editData(db)">
                                                    <p class="p-2">Edit</p>
                                                </a>
                                                <Link method="delete" :href="`/database/destroy/${db.id}`">
                                                <p class="p-2">Delete</p>
                                                </Link>
                                            </div>
                                        </fwb-dropdown>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Pagination class="mt-10" :links="data.links" />
                    </div>
                </div>
            </div>
            <fwb-modal v-if="isShowModal" @close="closeModal" persistent>
                <template #header>
                    <div class="flex items-center text-lg">
                        Tambah Data
                    </div>
                </template>
                <template #body>
                    <fwb-select v-model="form.connection" :options="[
                            { value: 'mysql', name: 'MySQL' },
                            { value: 'pgsql', name: 'PostgreSQL' }
                        ]" label="Select DB connection" :validation-status="status.connection">
                        <template #validationMessage>{{ error.connection }}</template>
                    </fwb-select>
                    <fwb-input v-model="form.host" required placeholder="e.g localhost or 127.0.0.1" label="DB Host"
                        :validation-status="status.host">
                        <template #validationMessage v-if="status.host">{{ error.host }}</template>
                    </fwb-input>
                    <fwb-input v-model="form.port" required placeholder="e.g 3306 or 5432" label="DB Port"
                        :validation-status="status.port">
                        <template #validationMessage v-if="status.port">{{ error.port }}</template>
                    </fwb-input>
                    <fwb-input v-model="form.name" required placeholder="e.g db_yayasan" label="DB Name"
                        :validation-status="status.name">
                        <template #validationMessage v-if="status.name">{{ error.name }}</template>
                    </fwb-input>
                    <fwb-input v-model="form.username" required label="DB Username"
                        :validation-status="status.username">
                        <template #validationMessage v-if="status.username">{{ error.username }}</template>
                    </fwb-input>
                    <fwb-input v-model="form.password" required label="DB Password"
                        :validation-status="status.password">
                        <template #validationMessage v-if="status.password">{{ error.password }}</template>
                    </fwb-input>
                </template>
                <template #footer>
                    <div class="flex justify-between">
                        <fwb-button @click="closeModal" color="alternative">
                            Cancel
                        </fwb-button>
                        <fwb-button @click="submitModal" color="green">
                            Submit
                        </fwb-button>
                    </div>
                </template>
            </fwb-modal>
            <fwb-toast type="warning" class="fixed top-5 right-5" closable v-if="gagal">
                Improve password difficulty.
            </fwb-toast>
            <fwb-toast type="success" class="fixed top-5 right-5" closable v-if="sukses">
                Item moved successfully.
            </fwb-toast>
        </div>
    </AuthenticatedLayout>
</template>
