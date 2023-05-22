<template>
    <div class="card mx-auto my-5 p-3 grid" style="width: 75%;height: 66.7%;">
        <p class="my-2 p-2 h4">إضافة مادة جديدة</p>
        <div class="my-2 p-2" style="max-width: fit-content;">
            <b-form-input style="width: 22rem;" placeholder="اسم المادة" autocomplete="off" v-model="course.name"
                type="text" required />
        </div>
        <div class="my-2 p-2" style="max-width: fit-content;">
            <b-form-select v-model="course.term" :options="this.terms" style="width: 22rem;height: 2rem;"
                placeholder="الفصل" required />
        </div>
        <div class="my-2 p-2 button-container">
            <b-button size="lg" :disabled="isLoading" @click.prevent="addCourse" class="inline-button">إضافة</b-button>
            <vue-ellipse-progress v-if="isLoading" class="mx-auto" :loading="true" :size="48"
                color="var(--background-blueish1)" :thickness="'10%'" :line="'butt'" />
        </div>


    </div>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            emptyCourse: {
                name: '',
                term: null,
            },
            course: {
                name: '',
                term: null,
            },
            terms: [{
                value: null,
                text: 'يرجى اختيار فصل'
            }, {
                value: 'الفصل الأول',
                text: 'الفصل الأول'
            }, {
                value: 'الفصل الثاني',
                text: 'الفصل الثاني'
            },]
        };
    },
    methods: {
        addCourse() {
            this.isLoading = true;
            axios.post('/api/add_course', {
                name: this.course.name,
                tirm_name: this.course.term
            })
                .then((res) => {
                    let data = res.data;
                    if (data.code == 200) {
                        this.$toast.success(data.msg);
                        this.course = this.emptyCourse;
                    }
                    else {
                        this.$toast.warning(data.msg);
                    }
                    this.isLoading = false;

                })
                .catch((error) => {
                    console.error(error);
                    this.$toast.error('حدث خطأ ما يرجى المحاولى مرة اخرى')
                    this.isLoading = false;
                })
        }
    }

}
</script>

<style scoped>
.grid {
    display: grid;
    grid-template-columns: repeat(360px);
    grid-template-rows: repeat(4, max-content);
}

.button-container {
    display: flex;
    justify-content: center;
    flex-direction: column;
    gap: .5rem;
}
</style>
