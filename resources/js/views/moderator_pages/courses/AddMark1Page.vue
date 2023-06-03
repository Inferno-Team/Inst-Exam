<template>
    <div v-if="!isStudentsLoaded">
        <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" @vdropzone-file-added="vfileAdded"
            class="drop-zone-style mx-auto"></vue-dropzone>
    </div>
    <div v-else>
        <div class="bg-white student-table m-3 p-3 rounded">
            <b-table sticky-header id="students-table" head-variant="light" :per-page="perPage" :current-page="currentPage"
                striped hover :fields="fields" :items="students"></b-table>
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
            fields: [
                {
                    key: 'univ_id',
                    label: 'الرقم الجامعي',
                    sortable: true
                },
                {
                    key: 'student_name',
                    label: 'اسم الطالب',
                    sortable: true
                },
                {
                    key: 'mark',
                    label: 'علامة العملي',
                    sortable: true
                },

            ]
        }
    },
    methods: {
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
            let _students = XLSX.utils.sheet_to_json(worksheet, {
                header: 0,
            });
            console.log(_students);
            this.students = _students;
            this.rows = this.students.length;
            this.isStudentsLoaded = true;
        },
        saveStudentsMarks() {
            axios.post('/api/save-student-mark1', {
                course_id : this.id,
                marks:this.students.map(function(item){
                    return {
                        univ_id : item.univ_id,
                        mark : item.mark
                    }
                })
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
        }
    }

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
