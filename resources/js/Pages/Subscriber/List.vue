<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";

export default {
    components: {
        Pagination,
        AuthenticatedLayout,
        Head,
        Link,
    },
    props: {
        model: {
            type: Object,
            required: true,
        },
    },
    methods: {
        nextPage() {
            if (!this.model.subscribers.next_page_url) {
                return;
            }

            this.$inertia.get(this.model.subscribers.next_page_url);
        },

        prevPage() {
            if (!this.model.subscribers.prev_page_url) {
                return;
            }

            this.$inertia.get(this.model.subscribers.prev_page_url);
        },
    },
};
</script>
<template>
    <Head title="Subscribers List" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Subscribers
            </h2>
            <Link
                href="/subscribers/create"
                as="button"
                type="button"
                class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded mt-2"
            >
                Add Subscriber
            </Link>
            <button
                class="bg-transparent hover:bg-gray-500 text-gray-700 font-semibold hover:text-white py-2 px-4 border border-gray-500 hover:border-transparent rounded ml-2"
                @click="importSubscribers()"
            >
                Import Subscribers
            </button>
        </template>
        <Pagination
            :total="model.total"
            :current_page="model.subscribers.current_page"
            @paginated-prev="prevPage()"
            @paginated-next="nextPage()"
        ></Pagination>
    </AuthenticatedLayout>
</template>
