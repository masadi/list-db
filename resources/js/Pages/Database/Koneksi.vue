<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {
    FwbAlert,
    FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
} from 'flowbite-vue'
defineProps({
    id: Number,
    data: Object,
})
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <template v-if="data.success">
                    <fwb-alert type="success">
                        Koneksi Berhasil.
                    </fwb-alert>
                    <fwb-table>
                        <fwb-table-head>
                            <fwb-table-head-cell>Nama Table</fwb-table-head-cell>
                            <fwb-table-head-cell>Nama Field</fwb-table-head-cell>
                            <fwb-table-head-cell>Type Field</fwb-table-head-cell>
                        </fwb-table-head>
                        <fwb-table-body>
                            <template v-for="item in data.listTables">
                                <fwb-table-row>
                                    <fwb-table-cell>{{ item.table }}</fwb-table-cell>
                                    <fwb-table-cell>
                                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                            <template v-for="field in item.fieldName">
                                                <tr>
                                                    <td>{{ field }}</td>
                                                </tr>
                                            </template>
                                        </table>
                                    </fwb-table-cell>
                                    <fwb-table-cell>
                                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                            <template v-for="field in item.fieldType">
                                                <tr>
                                                    <td>{{ field }}</td>
                                                </tr>
                                            </template>
                                        </table>
                                    </fwb-table-cell>
                                </fwb-table-row>
                            </template>
                        </fwb-table-body>
                    </fwb-table>
                </template>
                <template v-else>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <fwb-alert type="danger">
                                Koneksi Error! {{ data.message }}.
                            </fwb-alert>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
