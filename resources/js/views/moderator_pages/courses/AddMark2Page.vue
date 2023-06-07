<template>
    <div v-if="!isStudentsLoaded">
        <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" @vdropzone-file-added="vfileAdded"
            class="drop-zone-style mx-auto"></vue-dropzone>
    </div>
    <div v-else>
        <div class="bg-white student-table m-3 p-3 rounded">
            <b-table sticky-header id="students-table" head-variant="light" :per-page="perPage" :current-page="currentPage"
                hover :fields="fields" :items="students" :tbody-tr-class="rowClass">
                <template #cell(mark2)="data">
                    <div @dblclick="editable(data)">
                        <b-form-input type="number" v-if="students[data.index].is_edit"
                            v-model.number="data.item.mark2"></b-form-input>
                        <span v-else> {{ data.value }} </span>
                    </div>
                </template>
            </b-table>
            <b-pagination class="mt-4" style="justify-content: center;" v-model="currentPage" :total-rows="rows"
                :per-page="perPage" aria-controls="students-table"></b-pagination>
        </div>
        <div class="floating-container inner">
            <div class="floating-button" @click.prevent="saveStudentsMarks">
                <!-- <md-icon class="p-4">logout</md-icon> -->
                <BIconSave variant="dark" style="margin-top: 10px;padding: 3px;"></BIconSave>
            </div>
        </div>

    </div>
</template>

<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import * as XLSX from "xlsx";
export default {
    props: ['id'],
    components: { vueDropzone: vue2Dropzone, },
    data() {
        return {
            dropzoneOptions: {
                acceptedFiles:
                    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                // url: "https://httpbin.org/post",
                url: "http://localhost:8000/",
                autoProcessQueue: false,
                maxFilesize: 0.5,
                addRemoveLinks: true,
                // thumbnailWidth: 100,
                // thumbnailHeight: 100,
                maxFiles: 1,

                thumbnailMethod: "contain",
            },
            isStudentsLoaded: false,
            // students: [{"univ_id":2,"student_name":"امنه عون","mark":10},{"univ_id":3,"student_name":"شاكر وجيه","mark":20},{"univ_id":4,"student_name":"وجدان عبدالهادي","mark":30},{"univ_id":7,"student_name":"بسام منصف","mark":15},{"univ_id":8,"student_name":"مراد أحمد","mark":22},{"univ_id":2,"student_name":"امنه عون","mark":10},{"univ_id":3,"student_name":"شاكر وجيه","mark":20},{"univ_id":4,"student_name":"وجدان عبدالهادي","mark":30},{"univ_id":7,"student_name":"بسام منصف","mark":15},{"univ_id":8,"student_name":"مراد أحمد","mark":22},{"univ_id":2,"student_name":"امنه عون","mark":10},{"univ_id":3,"student_name":"شاكر وجيه","mark":20},{"univ_id":4,"student_name":"وجدان عبدالهادي","mark":30},{"univ_id":7,"student_name":"بسام منصف","mark":15},{"univ_id":8,"student_name":"مراد أحمد","mark":22},{"univ_id":2,"student_name":"امنه عون","mark":10},{"univ_id":3,"student_name":"شاكر وجيه","mark":20},{"univ_id":4,"student_name":"وجدان عبدالهادي","mark":30},{"univ_id":7,"student_name":"بسام منصف","mark":15},{"univ_id":8,"student_name":"مراد أحمد","mark":22},{"univ_id":2,"student_name":"امنه عون","mark":10},{"univ_id":3,"student_name":"شاكر وجيه","mark":20},{"univ_id":4,"student_name":"وجدان عبدالهادي","mark":30},{"univ_id":7,"student_name":"بسام منصف","mark":15},{"univ_id":8,"student_name":"مراد أحمد","mark":22},{"univ_id":2,"student_name":"امنه عون","mark":10},{"univ_id":3,"student_name":"شاكر وجيه","mark":20},{"univ_id":4,"student_name":"وجدان عبدالهادي","mark":30},{"univ_id":7,"student_name":"بسام منصف","mark":15},{"univ_id":8,"student_name":"مراد أحمد","mark":22},{"univ_id":2,"student_name":"امنه عون","mark":10},{"univ_id":3,"student_name":"شاكر وجيه","mark":20},{"univ_id":4,"student_name":"وجدان عبدالهادي","mark":30},{"univ_id":7,"student_name":"بسام منصف","mark":15},{"univ_id":8,"student_name":"مراد أحمد","mark":22},{"univ_id":2,"student_name":"امنه عون","mark":10},{"univ_id":3,"student_name":"شاكر وجيه","mark":20},{"univ_id":4,"student_name":"وجدان عبدالهادي","mark":30},{"univ_id":7,"student_name":"بسام منصف","mark":15},{"univ_id":8,"student_name":"مراد أحمد","mark":22},{"univ_id":2,"student_name":"امنه عون","mark":10},{"univ_id":3,"student_name":"شاكر وجيه","mark":20},{"univ_id":4,"student_name":"وجدان عبدالهادي","mark":30},{"univ_id":7,"student_name":"بسام منصف","mark":15},{"univ_id":8,"student_name":"مراد أحمد","mark":22}],
            students: [],
            perPage: 20,
            currentPage: 1,
            rows: 5,
            mark1_from_server: [],
            fields: [
                {
                    key: 'univ_id',
                    label: 'الرقم الجامعي',
                    sortable: true,
                    thStyle: { width: "20%" },

                },
                {
                    key: 'student_name',
                    label: 'اسم الطالب',
                    sortable: true,
                    thStyle: { width: "30%" },

                },
                {
                    key: 'mark1',
                    label: 'علامة العملي',
                    sortable: true,
                    thStyle: { width: "10%" },

                },
                {
                    key: 'mark2',
                    label: 'علامة النظري',
                    sortable: true,
                    thStyle: { width: "10%" },

                },
                {
                    key: 'full_mark',
                    label: 'علامة الكلية',
                    sortable: true,


                },
            ],

        }
    },
    methods: {
        rowClass(item, type) {
            if (!item || type !== 'row') return

            return item.full_mark < 60 ? 'bg-danger text-white' : 'bg-success text-white'
        },
        vfileAdded(file) {
            const reader = new FileReader();
            reader.onload = this.onFileLoaded;
            reader.readAsArrayBuffer(file);
        },
        onFileLoaded(event) {
            var data = new Uint8Array(event.target.result);
            console.log(data);
            let workbook = XLSX.read(data, { type: "array" });
            let first_sheet_name = workbook.SheetNames[0];
            let worksheet = workbook.Sheets[first_sheet_name];
            this.students = XLSX.utils.sheet_to_json(worksheet, {
                header: 0,
            }).map((item) => {
                return {
                    univ_id: item.univ_id,
                    student_name: item.student_name,
                    mark1: 0,
                    mark2: item.mark,
                    full_mark: 0,
                    is_edit: false
                }
            });
            this.rows = this.students.length;
            this.readMark1FromServer();
            // this.isStudentsLoaded = true;
        },
        saveStudentsMarks() {
            axios.post('/api/save-student-mark2', {
                course_id: this.id,
                marks: this.students.map((student) => {
                    return {
                        univ_id: student.univ_id,
                        mark: student.mark2
                    }
                }),

            })
                .then((res) => {
                    if (res.data.code == 200) {
                        this.$toast.success(res.data.msg);
                        this.$router.back();
                    }
                    else {
                        this.$toast.warning(res.data.msg);
                        console.log(res.data.errors);
                    }
                })
                .catch((error) => {
                    console.log(error);
                    this.$toast.error('حدث خطأ ما يرجى المحاولة مرة اخرى');
                })
        },
        readMark1FromServer() {
            axios.post('/api/get-students-mark1', {
                course_id: this.id,
                ids: this.students.map((item) => item.univ_id)
            })
                .then((response) => {
                    let data = response.data;
                    if (data.code == 200) {
                        let marks = data.marks;
                        marks.forEach(mark => {
                            this.students.find((student) => student.univ_id == mark.univ_id)['mark1'] = mark.mark1;
                        });
                        this.students.forEach((student) => {
                            student.full_mark = student.mark1 + student.mark2;
                        })
                    }
                    this.isStudentsLoaded = true;
                })
                .catch(console.error);
        },
        editable(data) {
            for (let index = 0; index < this.students.length; index++) {
                if (index == data.index) continue;
                this.students[index].is_edit = false;
            }
            this.students[data.index].is_edit = !this.students[data.index].is_edit;

            this.students[data.index].full_mark = this.students[data.index].mark1
                + this.students[data.index].mark2;
        }

    },

}
</script>

<style >
.drop-zone-style {
    min-height: 300px;
    position: relative;
    margin-top: 10rem;
    width: 38rem;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
}

.dz-error-message {
    top: 85px !important;
}

.student-table {
    clip-path: polygon(100% 0%, 100% 100%, 100% 100%, 100% 100%, -75% 100%, 25% 0%);
}



.b-table-sticky-header {
    max-height: 480px !important;
    height: 480px !important;
}


.inner {
    top: 1rem;
    left: 3rem;
}
</style>
