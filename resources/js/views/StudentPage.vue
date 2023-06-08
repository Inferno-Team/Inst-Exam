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
        <b-modal id="request-modal" hide-footer title="طلب كشف علامات">
            <div class="mx-auto">
                <b-container fluid>
                    <b-row class="my-3" style="justify-content: center;">
                        <b-col sm="5">
                            <h6> رقم الايصال المالي</h6>
                        </b-col>
                        <b-col sm="6">
                            <b-form-input autocomplete="off" v-model.number="request.no_financial_receipt"
                                type="number"></b-form-input>
                        </b-col>
                    </b-row>
                    <b-row class="my-3" style="justify-content: center;">
                        <b-col sm="5">
                            <h6>تاريخ قطع الايصال المالي</h6>
                        </b-col>
                        <b-col sm="6">
                            <DatePicker v-model="request.date_financial_receipt" :lang="lang" />
                        </b-col>
                    </b-row>
                    <b-row class="my-5" style="align-items: center;">
                        <b-button class="inline-button" @click.prevent="requestNewMarkRevel">انطلاق</b-button>
                        <b-button class="outline-button" @click.prevent="$bvModal.hide('request-modal')">اغلاق</b-button>
                    </b-row>

                </b-container>
            </div>
        </b-modal>
    </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
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
                            "full_mark": course.mark1 && course.mark2 ? course.mark1 + course.mark2 : null
                        };
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
                    key: "id",
                    label: "تسلسل",
                    sortable: true,
                    thStyle: { width: "5%" },
                },
                {
                    key: "name",
                    label: "اسم المادة",
                    sortable: true,
                    thStyle: { width: "10%" },
                },
                {
                    key: "status",
                    label: "الحالة",
                    sortable: true,
                    thStyle: { width: "5%" },
                },
                {
                    key: "mark1",
                    label: "علامة العملي",
                    sortable: true,
                    thStyle: { width: "5%" },
                },
                {
                    key: "mark2",
                    label: "علامة النظري",
                    sortable: true,
                    thStyle: { width: "10%" },
                },
                {
                    key: "full_mark",
                    label: "علامة الكلية",
                    sortable: true,
                    thStyle: { width: "10%" },
                },
                {
                    key: "year",
                    label: "السنة",
                    sortable: true,
                    thStyle: { width: "10%" },
                },
                {
                    key: "sectionYearTerm.section_name",
                    label: "القسم",
                    sortable: true,
                    thStyle: { width: "10%" },
                },
                {
                    key: "sectionYearTerm.year",
                    label: "السنة الدراسية",
                    sortable: true,
                    thStyle: { width: "10%" },
                },
                {
                    key: "sectionYearTerm.term",
                    label: "الفصل",
                    sortable: true
                },
            ],

            lang: {
                formatLocale: {
                    firstDayOfWeek: 1,
                },
                monthBeforeYear: false,
            },
            request: {
                date_financial_receipt: "",
                no_financial_receipt: null
            }
        };
    },
    methods: {
        logout() {
            axios.defaults.headers.common["Authorization"] = ``;
            localStorage.removeItem(CONSTANCES.TOKEN_NAME);
            window.location.href = "/login";
        },
        rowClass(item, type) {
            if (!item || type !== "row")
                return;
            return item.full_mark >= 60 ? "bg-success text-white" : item.full_mark == null ? "first_time_bg text-white" :
                "bg-danger text-white";
        },
        addMarkRevelRequest() {
            this.$bvModal.show("request-modal");
        },
        requestNewMarkRevel() {
            if (this.request.date_financial_receipt == "" || this.request.no_financial_receipt == null) {
                this.$toast.warning("يجب ادخال بيانات صحيحة");
                return;
            }
            this.request.date_financial_receipt = this.request.date_financial_receipt.getTime();
            axios.post("/api/request-new-marks-revel", this.request)
                .then((response) => {
                    let data = response.data;
                    if (data.code == 200) {
                        this.$toast.success(data.msg);
                    }
                    else
                        this.$toast.warning(data.msg);
                    this.$bvModal.hide("request-modal");
                })
                .catch((error) => {
                    console.log(error);
                    this.$toast.error('حدث خطأ ما يرجى المحاولة مرة اخرى لاحقا');

                })
        }
    },
    components: { DatePicker },
}
</script>

<style scoped>
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
</style>
