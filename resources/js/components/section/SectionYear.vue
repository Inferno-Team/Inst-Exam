<template>
    <div class="bg-white m-3 p-3 rounded">
        <h4 class=""> {{ year.name }}</h4>
        <b-table sticky-header head-variant="light" id="my-table" :per-page="perPage" :current-page="currentPage" striped
            hover :items="year.students" :fields="fields"></b-table>
        <b-pagination class="mt-4" style="justify-content: center;" v-model="currentPage" :total-rows="rows"
            :per-page="perPage" aria-controls="my-table"></b-pagination>
    </div>
</template>

<script>
export default {
    props: ['year'],
    data() {
        return {
            perPage: 20,
            currentPage: 1,
            fields: [
                {
                    key: 'id',
                    label: 'ت',
                    sortable: true
                },
                {
                    key: 'first_name',
                    label: 'اسم الطالب',
                    sortable: true
                },
                {
                    key: 'univ_id',
                    label: 'الرقم الجامعي',
                    sortable: true
                },
                {
                    key: 'father_name',
                    label: 'اسم الأب',
                    sortable: true
                },
                {
                    key: 'mother_name',
                    label: 'اسم الأم',
                    sortable: true
                },
                {
                    key: 'last_name',
                    label: 'اسم الكنية',
                    sortable: true
                },

            ]
        }
    },
    computed: {
        rows() {
            return this.year.students.length
        }
    }
}
</script>

<style  scoped>
.b-table-sticky-header {
    max-height: 360px !important;
    height: 360px !important;
}
</style>
