<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref  } from 'vue'
import { Head } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import { pickBy, throttle } from 'lodash';
defineProps({ data: Object })
const params = ref({
    search: '',
    field: 'connection',
    direction: 'asc'
})
const sort = (val) => {
    params.value.field = val
    params.value.direction = params.value.direction === 'asc' ? 'desc' : 'asc'
    console.log(val);
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
                <div class="mb-4 max-w-xs">
                    <input type="search" v-model="params.search" aria-label="Search" placeholder="Search..." class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
                </div>
                <div class="mb-4 max-w-xs">
                    button
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed table-bordered table-striped">
                            <thead class="bg-indigo-500">
                                <tr>
                                    <template v-for="item in ['connection', 'host', 'port', 'name', 'username', 'password']">
                                        <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                                            <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort(item)">{{ item }}
                                                <svg v-if="params.field === item && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                                </svg>
                                                <svg v-if="params.field === item && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                                </svg>
                                            </span>
                                        </th>
                                    </template>
                                    <th scope="col" class="text-xs font-semibold tracking-wider text-left text-white uppercase">Action</th>
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
                                        {{ db.password }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        aksi
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Pagination class="mt-10" :links="data.links"/>          
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
