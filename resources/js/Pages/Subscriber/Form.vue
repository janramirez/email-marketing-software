<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    components: {
        AuthenticatedLayout,
    },
    props: {
        model: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            form: {
                id: null,
                first_name: null,
                last_name: null,
                email: null,
                form_id: null,
                tag_ids: [],
            },
        };
    },
    created() {
        if (!this.model.subscriber) {
            return;
        }

        this.form = {
            id: this.model.subscriber.id,
            first_name: this.model.subscriber.first_name,
            last_name: this.model.subscriber.last_name,
            email: this.model.subscriber.email,
            form_id: this.model.subscriber.form.id,
            tag_ids: this.model.subscriber.tags.map((t) => t.id),
        };
    },
    methods: {
        submit() {
            if (this.model.subscriber) {
                this.$inertia.put(
                    `/subscribers/${this.model.subscriber.id}`,
                    this.form
                );
            } else {
                this.$inertia.post("/subscribers", this.form);
            }
        },
    },
};
</script>

<template>
    <AuthenticatedLayout>
        <div>
            <label for="first_name">First Name</label>
            <input
                v-model="form.first_name"
                id="first_name"
                type="text"
                placeholder="First Name"
            />
        </div>
        <div>
            <label for="first_name">Last Name</label>
            <input
                v-model="form.last_name"
                id="last_name"
                type="text"
                placeholder="Last Name"
            />
        </div>
        <div>
            <label for="first_name">Email</label>
            <input
                v-model="form.firsemailt_name"
                id="email"
                type="email"
                placeholder="Email"
            />
        </div>
    </AuthenticatedLayout>
</template>
