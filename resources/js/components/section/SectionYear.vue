<template>
    <div class="bg-white m-3 p-3 rounded">
        <h4 class=""> {{ year.name }}</h4>
        <b-table id="my-table" :per-page="perPage" :current-page="currentPage" striped hover
            :items="year.students"></b-table>
        <b-pagination class="mt-4" style="justify-content: center;" v-model="currentPage" :total-rows="rows"
            :per-page="perPage" aria-controls="my-table"></b-pagination>
    </div>
</template>

<script>
export default {
    props: ['year'],
    data() {
        return {
            perPage: 4,
            currentPage: 1,
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
.my_style {
    background-color: white;
    font-size: 17px;
    color: red;

}
</style>
