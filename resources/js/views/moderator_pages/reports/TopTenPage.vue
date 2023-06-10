<template>
    <div v-if="students.length > 0">
        <div class="floating-container" style="top: 1rem; left: 1rem;background-color: transparent;">
            <div class="floating-button" @click.prevent="print">طباعة</div>
        </div>
        <div id="printable" class="bg-white m-3 p-3 rounded" style="height:600px">
            <div class="title"> درج فيما يلي تقرير بالعشر الأوائل على قسم {{ section_name }} في العام الدراسي {{ year_date
            }} - {{ year_name }} </div>
            <b-table class="table" :fields="fields" id="my-table" :per-page="perPage" :current-page="currentPage" striped
                :items="students"></b-table>
        </div>
    </div>
</template>

<script>
import html2PDF from "jspdf-html2canvas";

export default {
    mounted() {
        axios.get('/api/top-ten')
            .then((r) => {
                let data = r.data.data;
                this.students = data.top10;
                this.year_date = data.year_date;
                this.section_name = data.section;
                this.year_name = data.year;
            })
    },
    data() {
        return {
            perPage: 10,
            currentPage: 1,
            students: [],
            fields: [
                {
                    key: "id",
                    label: "تسلسل"
                },
                {
                    key: "univ_id",
                    label: "رقم الجامعي"
                },
                {
                    key: "name",
                    label: "اسم الطالب"
                },
                {
                    key: "full_mark",
                    label: "المعدل"
                },

            ],
            section_name: '',
            year_name: '',
            year_date: ''
        }
    },
    methods: {
        print() {
            let printable = document.getElementById("printable");
            html2PDF(printable, {
                jsPDF: {
                    format: "a4",
                },
                imageType: "image/jpeg",
                output: `ملف العشر الاوائل.pdf`,
            });
        },
    },
}
</script>

<style scoped>
.floating-button {
    opacity: 0.4;
    transition: 500ms;
    background-color: transparent;
    color: black;
    font-size: 16px;
    line-height: 41px;
}

.title {

    font-size: 1.25rem;
    font-weight: bold;
    text-align: center;
    margin: 3rem 0;

}

.table {
    width: 800px;
    margin: 0 auto;
}

.floating-container:hover .floating-button {
    opacity: 1;
    background-color: white;
}
</style>
