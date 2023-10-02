<script>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination';

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
    }
}
    
</script>
<template>
    <Pagination
        :total="model.total"
        :current_page="model.subscribers.current_page"
        @paginated-prev="prevPage()"
        @paginated-next="nextPage()"
    ></Pagination>
</template>