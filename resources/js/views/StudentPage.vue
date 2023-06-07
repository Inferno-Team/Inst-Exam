<template>
    <div class="dashboard">
        <!-- <sidebar-menu :menu="menu" :rtl="true" :relative="true" /> -->
        <div class="my-container">
            <div class="bg-white  student-table m-3 p-3 rounded">
                <b-table sticky-header head-variant="light" id="my-table" :per-page="perPage" :current-page="currentPage"
                    hover :items="courses" :fields="fields" :tbody-tr-class="rowClass"></b-table>
                <b-pagination class="mt-4" style="justify-content: center;" v-model="currentPage" :total-rows="rows"
                    :per-page="perPage" aria-controls="my-table"></b-pagination>
            </div>
        </div>
        <div class="floating-container">
            <div class="floating-button" @click.prevent="logout">
                <!-- <md-icon class="p-4">logout</md-icon> -->
                <BIconArrowUpRightSquare variant="dark" style="margin-top: 10px;padding: 3px;"></BIconArrowUpRightSquare>
            </div>
        </div>
        <div class="floating-container inner">
            <div class="floating-button" @click.prevent="addMarkRevelRequest">
                <!-- <md-icon class="p-4">logout</md-icon> -->
                <p>طلب كشف علامات</p>
            </div>
        </div>

    </div>
</template>

<script>
import StudentCourse from '../components/StudentCourse.vue';
import { CONSTANCES } from '../utils'
export default {
    mounted() {
        const token = localStorage.getItem(CONSTANCES.TOKEN_NAME);
        if (token == null || token == undefined) {
            this.$router.push({
                name: "login-page"
            });
            return;
        }
        axios.get("/api/get-my-courses")
            .then((response) => {
                let data = response.data;
                if (data.code == 200) {
                    this.courses = data.courses.map(function (course) {
                        return {
                            ...course,
                            'full_mark': course.mark1 && course.mark2 ? course.mark1 + course.mark2 : null
                        }
                    });
                }
                else {
                    console.log(data.msg);
                }
            })
            .catch(console.error);
    },

    data() {
        return {
            perPage: 20,
            rows: 5,

            currentPage: 1,
            courses: [],
            fields: [
                {
                    key: 'id',
                    label: 'تسلسل',
                    sortable: true,
                    thStyle: { width: "5%" },
                },
                {
                    key: 'name',
                    label: "اسم المادة",
                    sortable: true,
                    thStyle: { width: "10%" },
                },
                {
                    key: 'status',
                    label: "الحالة",
                    sortable: true,
                    thStyle: { width: "5%" },
                },
                {
                    key: 'mark1',
                    label: "علامة العملي",
                    sortable: true,
                    thStyle: { width: "5%" },
                },
                {
                    key: 'mark2',
                    label: "علامة النظري",
                    sortable: true,
                    thStyle: { width: "10%" },
                },
                {
                    key: 'full_mark',
                    label: "علامة الكلية",
                    sortable: true,
                    thStyle: { width: "10%" },
                },
                {
                    key: 'year',
                    label: "السنة",
                    sortable: true,
                    thStyle: { width: "10%" },
                },
                {
                    key: 'sectionYearTerm.section_name',
                    label: "القسم",
                    sortable: true,
                    thStyle: { width: "10%" },
                },
                {
                    key: 'sectionYearTerm.year',
                    label: "السنة الدراسية",
                    sortable: true,
                    thStyle: { width: "10%" },
                },
                {
                    key: 'sectionYearTerm.term',
                    label: "الفصل",
                    sortable: true
                },

            ]
        };
    },
    methods: {
        logout() {
            axios.defaults.headers.common["Authorization"] = ``;
            localStorage.removeItem(CONSTANCES.TOKEN_NAME);
            window.location.href = "/login";
        },
        rowClass(item, type) {
            if (!item || type !== 'row') return

            return item.full_mark >= 60 ? 'bg-success text-white' : item.full_mark == null ? 'first_time_bg text-white' :
                'bg-danger text-white';

        },
        addMarkRevelRequest(){

        }
    },
}
</script>

<style >
.dashboard {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.student-table {
    clip-path: polygon(100% 0%, 100% 100%, 100% 100%, 100% 100%, 100%)
}

.dashboard .my-container {
    width: 100%;
    height: 100%;
    background: #ccc;
    /* grid-template-columns: repeat(3, minmax(200px, 1fr));
    display: grid;
    overflow-y: auto;
    justify-items: center
    */
}

.inner {
    top: 1rem;
    left: 3rem;
    width: 120px;
}

.inner .floating-button {
    color: black;
    width: 160px;
    border-radius: 1rem;
    line-height: 44px;
}

.inner p {
    font-size: 1rem;
}
.first_time_bg{
    background-color:purple;
}
</style>
