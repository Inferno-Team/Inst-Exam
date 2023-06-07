<template>
    <div>
        <div class="bg-white m-3 p-3 rounded " :class="{ 'student-table': !is_admin }">
            <h4 style="width: 20rem;"> القسم : {{ section.name }} </h4>
            <SectionYear v-for="(year, index) in section.years" :key="index" :year="year" />
        </div>
        <div class="floating-container inner" v-if="!is_admin">
            <div class="floating-button" @click.prevent="downloadAsExcel">
                <!-- <md-icon class="p-4">logout</md-icon> -->
                <BIconSave variant="dark" style="margin-top: 10px;padding: 3px;"></BIconSave>
            </div>
        </div>
    </div>
</template>

<script>
import SectionYear from './SectionYear.vue';
import * as XLSX from "xlsx";

export default {
    name: "x-section",
    props: ["section", 'is_admin'],
    components: { SectionYear },

    methods: {
        downloadAsExcel() {
            let workbook = XLSX.utils.book_new();
            let new_students = this.section.years[0].students.map(function (item) {
                return {
                    serial: item.id,
                    univ_id: item.univ_id,
                    student_name: `${item.first_name} ${item.last_name}`,
                    mark: ""
                };
            });

            let worksheet = XLSX.utils.json_to_sheet(new_students, {
                header: ["serial", "univ_id", "student_name", "mark"]
            });
            XLSX.utils.book_append_sheet(workbook, worksheet, `${this.section.name} - ${this.section.years[0].name}`);
            XLSX.writeFileXLSX(workbook, `${this.section.name} - ${this.section.years[0].name}.xlsx`)
        }
    }
}
</script>

<style  scoped></style>
