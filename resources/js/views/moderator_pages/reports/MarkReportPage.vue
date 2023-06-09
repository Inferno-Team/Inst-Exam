<template>
    <div style="height: 100%; overflow-y: auto;">
        <div class="floating-container" style="top: 1rem; left: 1rem;background-color: transparent;">
            <div class="floating-button" @click.prevent="printPDF">طباعة</div>
        </div>
        <div id="printable" class="mark-report" v-if="student != null">
            <div class="report-header">
                <div class="report-header-first">
                    <div class="title">الجمهورية العربية السورية</div>
                    <div class="title">جامعة حلب</div>
                    <div class="title">معهد {{ student.section_name.ar }}</div>
                </div>
                <div class="report-header-second">
                    <img src="/images/logo.png" height="90px">
                </div>
                <div class="report-header-third">
                    <div class="title">Syrian Arab Republic</div>
                    <div class="title">{{ student.section_name.en }} Institute</div>
                </div>
            </div>
            <div class="line"></div>
            <div class="report-body mt-4">
                <div class="report-body-title mx-auto">كشف عـــــــــــلامات</div>
                <div class="report-body-subtitle">
                    ندرج فيما يلي كشفا بالمقرارات التي درسها الطالب
                    <div class="report-body-subtitle-student"> {{ student.full_name }} </div>
                    بن
                    <div class="report-body-subtitle-student"> {{ student.father_name }} </div>
                    المولود في
                    <div class="report-body-subtitle-student"> {{ student.birth_place }} </div>
                    عام
                    <div class="report-body-subtitle-student"> {{ student.year_of_birth }} </div>
                    و المتمتع بالجنسية
                    <div class="report-body-subtitle-student"> {{ student.nationalty }} </div>
                    من قسم
                    <div class="report-body-subtitle-student"> {{ student.section_name.ar }} </div>
                    في السنوات التي قضاها في المعهد
                    <div class="report-body-subtitle-student"> {{ student.section_name.ar }} </div>
                    في جامعة حلب اعتبارا من العام الدراسي
                    <div class="report-body-subtitle-student"> {{ student.first_year }} </div>
                    ولغاية عام
                    <div class="report-body-subtitle-student"> {{ student.last_year }} </div>
                    والعلامات التي نالها في كل المقررات كالتالي :
                </div>
                <div class="report-mark-table">
                    <div v-for="(value, key, index) in courses" :key="index">
                        <table v-for="(v, k, i) in value" :key="i">
                            <tr>
                                <th colspan="8">مقررات {{ k }} - {{ key }} للعام الدراسي {{ statuses[key][0].year }} </th>
                            </tr>
                            <tr>
                                <th>المقررات التقنية</th>
                                <th colspan="3">العلامة</th>
                                <th>المقررات العلمية</th>
                                <th colspan="3">العلامة</th>
                            </tr>
                            <tr v-for="(_x, ele) in v['عملية'].length" :key="ele">
                                <!-- <div v-for="(student_course, iii) in v['تقنية']" :key="iii"> -->
                                <td colspan="4" v-if="!v['تقنية'][ele]"></td>
                                <td v-if="v['تقنية'][ele]">{{ v['تقنية'][ele].course.name }}</td>
                                <td v-if="v['تقنية'][ele]"> {{ v['تقنية'][ele].mark1 + v['تقنية'][ele].mark2 }} </td>
                                <td v-if="v['تقنية'][ele]">100%</td>
                                <td v-if="v['تقنية'][ele]">{{ v['تقنية'][ele].status }}</td>
                                <!-- </div> -->
                                <!-- <div v-for="(student_course, iii) in v['عملية']" :key="iii"> -->
                                <td>{{ v['عملية'][ele].course.name }}</td>
                                <td> {{ v['عملية'][ele].mark1 + v['عملية'][ele].mark2 }} </td>
                                <td>100%</td>
                                <td>{{ v['عملية'][ele].status }}</td>

                            </tr>



                        </table>
                    </div>
                </div>
                <div class="bottom-container">
                    <div class="report-body-subtitle-student">
                        يكون الطالب المذكور اعلاه راسب في السنة الثانية للمرة الثانية من المعهد التقاني الهندسي باختصاص
                        الهندسة الصحية والمحطات بنتيجة امتحان الدورة الثانية للعام الدراسي 2021/2022
                    </div>
                    <br>
                    <div class="report-body-subtitle-student">
                        وبموجب الإيصال المالي رقم ({{ request.no }}) تاريخ {{ request.date }}
                    </div>
                    <br>
                    <div class="report-body-subtitle-student">كل حك أو شطب في هذا الكشف يلغيه</div>
                    <div class="sigs">
                        <div class="sig">
                            <div class="title">مدقق السنة الأولى</div>
                            <div class="title"> {{ sections[0].moderator.first_name }} {{ sections[0].moderator.last_name }}
                            </div>
                        </div>
                        <div class="sig">
                            <div class="title">مدقق السنة الثانية</div>
                            <div class="title"> {{ sections[1].moderator.first_name }} {{ sections[1].moderator.last_name }}
                            </div>
                        </div>
                        <div class="sig">
                            <div class="title">مدقق رئيس شعبة الامتحانات</div>
                            <div class="title">أ.عمار الأغا</div>
                        </div>
                        <div class="sig">
                            <div class="title">مدير المعهد التقاني الهندسي</div>
                            <div class="title">د.م.مصطفى العلي</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import html2PDF from "jspdf-html2canvas";

export default {
    props: ['id'],
    mounted() {
        axios.get(`/api/student-mark-report-data/${this.id}`)
            .then((response) => {
                if (response.data.code != 200) {
                    console.log(response.data.msg);
                    return;
                }
                let data = response.data.data;
                let student = data.student;
                this.sections = data.section;
                this.statuses = data.statuses;
                for (let prop in data.courses) {
                    let courses = data.courses[prop];
                    let term_courses = _.groupBy(courses, 'course.section_year_term.year_term.name')
                    for (let type in term_courses) {
                        let c = term_courses[type];
                        let typed_courses = _.groupBy(c, 'course.type')
                        term_courses[type] = typed_courses;
                    }
                    // let obj = {};
                    this.courses[prop] = term_courses;
                    // obj[prop] = typed_courses;
                    // this.courses.push(obj);
                }
                // this.courses = data.courses.forEach(course => {
                //     console.log(course.name);
                // });

                this.student = {
                    ...student.student,
                    "section_name": student.section_name
                };
                this.request = data.request;
            })
            .catch(console.error)
    },
    data() {
        return {
            student: null,
            sections: null,
            request: null,
            statuses: [],
            courses: {},
        }
    },
    methods: {
        printPDF() {
            let printable = document.getElementById("printable");
            html2PDF(printable, {
                jsPDF: {
                    format: "a4",
                },
                imageType: "image/jpeg",
                output: ` كشف علامات للطالبة  ${this.student.full_name}.pdf`,
            });
            // const doc = new jsPDF({
            //   orientation: "landscape",
            //   unit: "in",
            //   format: [4, 2],
            // });
        },
    }

}
</script>

<style scoped>
.mark-report {
    padding: 1.75rem;
}

.report-body-title {
    max-width: fit-content;
    text-decoration: underline;
    font-size: 21px;
    text-underline-offset: 0.125rem;
}

.report-body-subtitle,
.report-body-subtitle-student {
    display: inline;
}

.report-body-subtitle-student {
    font-weight: bold;
}

.report-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.report-header-third {
    text-align: end;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 75px;

}

.line {
    height: 4px;
    background-color: black;
    margin-top: 4px;
}

.title {
    font-weight: 800;
}

table {
    width: 100%;
    /* display: inline-block; */
    border-collapse: collapse;
}

th,
td {
    border: 1px solid;
    padding: 0.5rem;
    text-align: center;
}

.floating-button {
    opacity: 0.4;
    transition: 500ms;
    background-color: transparent;
    color: black;
    font-size: 16px;
    line-height: 41px;
}

.floating-container:hover .floating-button {
    opacity: 1;
    background-color: white;
}

.sigs {
    display: flex;
    justify-content: space-around;
    align-items: center;
}

.sig {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 65px;
    align-items: center;
}
</style>
