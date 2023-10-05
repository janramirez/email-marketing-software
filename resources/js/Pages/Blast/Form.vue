<script>
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import FiltersForm from "@/Components/Filter/Form.vue";
// import PerformanceLine from '@/Components/Mail/PerformanceLine';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link,
        FiltersForm,
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
                subject: null,
                content: null,
                filters: {
                    tag_ids: [],
                    form_ids: [],
                },
            },
        };
    },
    created() {
        if (!this.model.blast) {
            return
        }

        this.form = {
            id: this.model.blast.id,
            subject: this.model.blast.subject,
            content: this.model.blast.content,
            filters: {
                form_ids: this.model.blast.filters.form_ids,
                tag_ids: this.model.blast.filters.tag_ids,
            },
        }
    },
    methods: {
        submit() {
            if(this.model.blast){
                this.$inertia.put(`/blasts/${this.model.blast.id}`, this.form)
            } else {
                this.$inertia.post('/blasts', this.form)
            }
        },
        updateFilters(filters) {
            this.form.filters.tag_ids = filters.tagIds;
            this.form.filters.form_ids = filters.formIds;

            console.log(filters);
        }
    },
};
</script>

<template>
    <Head title="New Blast Email" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2>New Email Blast</h2>
        </template>
        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
            {{ form.progress.percentage }}
        </progress>
        <div class="py-12 max-w-7xl mx-auto">
            <form
                @submit.prevent="submit"
                class="w-full mx-auto max-w-lg border rounded-md p-6 bg-white shadow-lg"
            >
                <fieldset>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label
                                for="subject"
                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            >
                                Subject
                            </label>
                            <input
                                v-model="form.subject"
                                id="subject"
                                type="text"
                                placeholder="My New Email Blast"
                                class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                            />
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label
                                for="content"
                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            >
                                Content
                            </label>
                            <textarea
                                v-model="form.content"
                                id="subject"
                                type="text"
                                rows="10"
                                placeholder="&lt;---This is where your HTML email content goes---&gt;"
                                class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            ></textarea>
                        </div>
                    </div>
                    <FiltersForm
                        :tags="model.tags"
                        :forms="model.forms"
                        :initial-selected-form-ids="form.filters.form_ids"
                        :initial-selected-tag-ids="form.filters.tag_ids"
                        @filtersChanged="updateFilters($event)"
                    />
                    <div class="flex justify-end items-center">
                        <Link
                            href="/blasts"
                            class="text-slate-500 hover:text-slate-700"
                        >
                            Cancel
                        </Link>
                        <button
                            type="submit"
                            class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        >
                            Save
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </BreezeAuthenticatedLayout>
</template>
