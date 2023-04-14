<script>
export default {
    page: {
        title: "Gosu Board",
        meta: [{ name: "description" }],
    },
    components: {
    },
    data() {
        return {
            title: "Analytics",
            items: [
                {
                    text: "Gosu",
                    href: "/",
                },
                {
                    text: "analytics",
                    active: true,
                },
            ],
        };
    },
    computed: {
    },
    methods: {
    },
    async created() {
    },

    async mounted() {
    },
};
</script>
<template>
    <div class="container-fluid min-vh-100">
        <PageHeader :title="title" :items="items" />
    </div>
</template>