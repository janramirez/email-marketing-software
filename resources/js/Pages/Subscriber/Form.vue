<script>
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link,
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
    <Head title="New Subscriber" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl tex-gray-800 leading-tight">
                New Subscriber
            </h2>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <form @submit.prevent="submit" class="w-full max-w-lg mx-auto bg-white border rounded-md p-6 shadow-lg shadow-slate-400">
                <div class="border rounded bg-green-50 flex items-center justify-between p-2 mb-6">
                    <p class="text-slate-500 text-xs m-2">
                        Add a new subscriber. Form is optional. Tags are recommended so that they can be added to filters.
                    </p>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label
                            for="first_name"
                            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            >First Name</label
                        >
                        <input
                            v-model="form.first_name"
                            id="first_name"
                            type="text"
                            placeholder="First Name"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus-outline-none focus:bg-white"
                        />
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label
                            for="first_name"
                            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            >Last Name</label
                        >
                        <input
                            v-model="form.last_name"
                            id="last_name"
                            type="text"
                            placeholder="Last Name"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        />
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label
                            for="email"
                            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            >Email</label
                        >
                        <input
                            v-model="form.email"
                            id="email"
                            type="email"
                            placeholder="Email"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        />
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label
                            for="form"
                            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        >
                            Form
                        </label>
                        <div class="relative">
                            <select
                                v-model="form.form_id"
                                id="form_id"
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            >
                                <option :value="null">-</option>
                                <option
                                    :value="form.id"
                                    v-for="form in model.forms"
                                    :key="form.id"
                                >
                                    {{ form.title }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label
                            for="tag_ids"
                            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        >
                            Tags
                        </label>
                        <div class="relative">
                            <select
                                v-model="form.tag_ids"
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="tag_ids multiple"
                            >
                                <option
                                    :value="tag.id"
                                    v-for="tag in model.tags"
                                    :key="tag.id"
                                >
                                    {{ tag.title }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end mt-10 w-full gap-3">
                    <Link href="/subscribers" class="text-indigo-600 ml-4">
                        Cancel
                    </Link>
                    <button
                        type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    >
                        Save
                    </button>
                </div>
            </form>
        </div>
    </BreezeAuthenticatedLayout>
</template>
