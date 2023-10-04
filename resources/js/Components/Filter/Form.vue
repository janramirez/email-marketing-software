<script>
export default {
    name: "FiltersForm",
    props: {
        forms: {
            type: Array,
            required: true,
        },
        tags: {
            type: Array,
            required: true,
        },
        initialSelectedTagIds: {
            type: Array,
            required: false,
        },
        initialSelectedFormIds: {
            type: Array,
            required: false
        }
    },
    data() {
        return {
            selectedTagIds: [],
            selectedFormIds: [],
        }
    },
    watch: {
        initialSelectedFormIds: function (value) {
            this.initialSelectedFormIds = value;
        },
        initialSelectedTagIds: function (value) {
            this.initialSelectedTagIds = value;
        }
    },
    created() {
        this.selectedTagIds = this.initialSelectedTagIds;
        this.selectedFormIds = this.initialSelectedFormIds;
    },
    methods: {
        filtersChanged() {
            this.$emit('filters-changed', {
                tagIds: this.selectedTagIds,
                formIds: this.selectedFormIds
            })
        }
    }
};
</script>

<template>
    <div>
        <label
            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
        >
            Filters
        </label>
        <div class="flex flex-wrap -mx-3 mb-2">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label
                    for="form_ids"
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                >
                    Forms
                </label>
                <div class="relative">
                    <select
                        class="block appearance-none w-full bg-gray-100 border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    >
                        <option
                            :value="form.id"
                            v-for="form in forms"
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
                        class="block appearance-none w-full bg-gray-100 border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    >
                        <option
                            :value="tag.id"
                            v-for="tag in tags"
                            :key="tag.id"
                        >
                            {{ tag.title }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>
