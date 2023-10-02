<script>
export default {
    props: {
        total: Number,
        current_page: Number,
    },
}
</script>

<template>
    <div>
        <div>
            <div>Total: {{ this.total }}</div>
        </div>
        <div>
            <button
                @click="$emit('paginatedPrev')"
                :disabled="this.current_page === 1"
            >
                Prev
            </button>
            <button @click="$emit('paginatedNext')">Next</button>
        </div>
    </div>
</template>
