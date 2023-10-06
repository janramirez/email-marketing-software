<script>
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import PerformanceLine from '@/Components/Mail/PerformanceLine.vue';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link,
        PerformanceLine
    },
    props: {
        model: {
            type: Object,
            required: true,
        },
    },
    methods: {
        edit(blast) {
            // this.$inertia.get(`blasts/${blast.id}/edit`);
            console.log(blast);
        },

        async send(blast) {
            // confirmation alert

        },
        preview(blast) {
            console.log(blast.id);
            this.$inertia.get(`blasts/${blast.id}/preview`);
        },
        async remove(blast) {
            this.$inertia.delete(`blasts/${blast.id}`);
        }
    }
};
</script>
<template>
    <Head title="Email blasts" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                All Email Blasts
            </h2>
            <Link
                href="/blasts/create"
                as="button"
                type="button"
                class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded mt-2"
            >
                New Blast
            </Link>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <table class="min-w-full divide-y divide-gray-200 mx-16">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Subject
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Status
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Performance
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        ></th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr
                        v-for="blast in model.blasts"
                        :key="blast.id"
                        class="hover:bg-slate-100"
                    >
                        <td class="px-6 py-4 hover:cursor-pointer" @click="">
                            <div class="text-sm text-gray-900">
                                {{ blast.subject }}
                            </div>
                        </td>
                        <td class="px-6 py-4" @click="">
                            <div class="text-sm text-gray-900">
                                {{ blast.status }}
                            </div>
                        </td>
                        <td class="px-6 py-4" @click="">
                            <PerformanceLine
                                v-if="blast.status !== 'draft'"
                                :performance="model.performances[blast.id]"
                            ></PerformanceLine>
                            <div v-else>-</div>
                        </td>
                        <td class="px-6 py-4">
                            <button
                                @click="preview(blast)"
                                class="bg-transparent hover:bg-blue-500 text-blue-700 hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                                type="button"
                            >
                                Preview
                            </button>
                            <button
                                v-if="blast.status !== 'sent'"
                                @click="send(blast)"
                                class="ml-2 bg-transparent hover:bg-green-500 text-green-700 hover:text-white py-2 px-4 border border-green-500 hover:border-transparent rounded"
                                type="button"
                            >
                                Send
                            </button>
                            <button
                                @click="remove(blast)"
                                class="ml-2 bg-transparent hover:bg-red-500 text-red-700 hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded"
                                type="button"
                            >
                                Remove
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </BreezeAuthenticatedLayout>
</template>
