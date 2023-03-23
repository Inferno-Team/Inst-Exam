<template>
    <tr>
        <th scope="row">{{ index + 1 }}</th>
        <th scope="row">{{ moderator.first_name }}</th>
        <th scope="row">{{ moderator.last_name }}</th>
        <th scope="row">{{ moderator.phone_number }}</th>
        <th scope="row">{{ moderator.year.created_at }}</th>
        <th scope="row">{{ moderator.year.year_name }}</th>
        <th scope="row"><b-icon @click.prevent="triggerEdit" icon="pencil-fill"
                style="color: rgb(245 255 95);cursor: pointer;"></b-icon></th>
        <th scope="row"><b-icon @click.prevent="triggerRemove" icon="trash-fill" style="cursor: pointer;"
                variant="danger"></b-icon></th>

    </tr>
</template>

<script>
export default {
    props: ['moderator', 'index'],
    data() {
        return {

        }
    },
    methods: {
        triggerEdit() {
            this.$emit('edit', {
                index: this.index + 1,
                moderator: this.moderator,
                yearId: this.moderator.year.year_id
            });
        },
        triggerRemove() {
            this.$emit('remove', {
                index: this.index + 1,
                moderator: this.moderator,
                yearId: this.moderator.year.year_id
            });
        }

    }
}
</script>

<style scoped>
th,
td {
    border: 1px solid;
    padding: 0.5rem;
    text-align: center;
    /* display: block; */
}
</style>