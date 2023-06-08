<template>
    <div class="mark-report" v-if="student != null">
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

        </div>
    </div>
</template>

<script>
export default {
    props: ['id'],
    mounted() {
        axios.get(`/api/student-mark-report-data/${this.id}`)
            .then((response) => {
                console.log(response.data);
                let data = response.data;
                if (data.code == 200)
                    this.student = {
                        ...data.student.student,
                        "section_name": data.student.section_name
                    };
            })
            .catch(console.error)
    },
    data() {
        return {
            student: null,
        }
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
</style>
