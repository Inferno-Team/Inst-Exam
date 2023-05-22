<template>
    <div class="bg-white m-3 p-3 rounded">
        <h4 class=""> المواد</h4>
        <b-table @row-clicked="onCourseClicked" id="my-table" :per-page="perPage" :current-page="currentPage" striped hover
            :items="courses"></b-table>
        <b-pagination class="mt-4" style="justify-content: center;" v-model="currentPage" :total-rows="rows"
            :per-page="perPage" aria-controls="my-table"></b-pagination>

        <b-modal id="marks-modal" hide-footer title="إضافة علامات">
            <div class="mx-auto">
                <b-container fluid>
                    <b-row class="my-3" style="justify-content: center;">
                        <b-col sm="7">
                            <b-form-select v-model="selectedOption" :options="options"></b-form-select>
                        </b-col>
                    </b-row>
                    <b-row class="my-5" style="align-items: center;">
                        <b-button :disabled="selectedOption == null" class="inline-button"
                            @click.prevent="goToPage">انطلاق</b-button>
                        <b-button class="outline-button" @click.prevent="$bvModal.hide('marks-modal')">اغلاق</b-button>
                    </b-row>

                </b-container>
            </div>
        </b-modal>
    </div>
</template>

<script>
export default {
    mounted() {
        axios.get('/api/my_courses')
            .then((res) => {
                console.log(res.data);
                this.courses = res.data.courses;
            }).catch(console.error);


    },
    data() {
        return {
            perPage: 4,
            currentPage: 1,
            courses: [],
            selectedOption: null,
            selectedCourse: null,
            options: [
                {
                    text: 'يرجى اختيار', value: null,
                },
                {
                    text: 'إضافة علامة عملي', value: "add-mark1",
                },
                {
                    text: 'إضافة علامة نظري', value: 'add-mark2',
                },

            ]
        }
    },
    methods: {
        onCourseClicked(course, index) {
            this.$bvModal.show('marks-modal');
            this.selectedCourse = course;
        },
        goToPage() {
            this.$bvModal.hide('marks-modal')
            this.$router.push({
                name: this.selectedOption,
                params: {
                    courseId: this.selectedCourse.id
                }
            });
        }
    },
    computed: {
        rows() {
            return this.courses.length
        }
    }
}
</script>

<style scoped></style>
