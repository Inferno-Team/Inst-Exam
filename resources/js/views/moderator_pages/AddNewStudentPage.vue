<template>
    <div class="my-5 bg-white rounded mx-4 p-4">
        <b-container fluid>

            <b-row>
                <b-col>
                    <b-row class="my-3">
                        <b-col sm="5">
                            <label style="font-size: 14px;">اسم الطالب :</label>
                        </b-col>
                        <b-col sm="7">
                            <b-form-input autocomplete="off" v-model="new_student.first_name" type="text"></b-form-input>
                        </b-col>
                    </b-row>

                </b-col>
                <b-col>
                    <b-row class="my-3">
                        <b-col sm="5">
                            <label style="font-size: 14px;">اسم الأب :</label>
                        </b-col>
                        <b-col sm="7">
                            <b-form-input autocomplete="off" v-model="new_student.father_name" type="text"></b-form-input>
                        </b-col>
                    </b-row>

                </b-col>

            </b-row>
            <b-row>
                <b-col>
                    <b-row class="my-3">
                        <b-col sm="5">
                            <label style="font-size: 14px;">اسم الأم :</label>
                        </b-col>
                        <b-col sm="7">
                            <b-form-input autocomplete="off" v-model="new_student.mother_name" type="text"></b-form-input>
                        </b-col>
                    </b-row>
                </b-col>
                <b-col>

                    <b-row class="my-3">
                        <b-col sm="5">
                            <label style="font-size: 14px;">الكنية :</label>
                        </b-col>
                        <b-col sm="7">
                            <b-form-input autocomplete="off" v-model="new_student.last_name" type="text"></b-form-input>
                        </b-col>
                    </b-row>
                </b-col>

            </b-row>
            <b-row>
                <b-col>
                    <b-row class="my-3">
                        <b-col sm="5">
                            <label style="font-size: 14px;">مكان الولادة :</label>
                        </b-col>
                        <b-col sm="7">
                            <b-form-input autocomplete="off" v-model="new_student.birth_place" type="text"></b-form-input>
                        </b-col>
                    </b-row>

                </b-col>
                <b-col>
                    <b-row class="my-3">
                        <b-col sm="5">
                            <label style="font-size: 14px;">الجنس :</label>
                        </b-col>
                        <b-col sm="7">
                            <b-form-select :options="this.gender_options" placeholder="يرجى اختيار جنس الطالب"
                                v-model="new_student.gender" type="text"></b-form-select>
                        </b-col>
                    </b-row>

                </b-col>

            </b-row>

            <b-row>
                <b-col>

                    <b-row class="my-3">
                        <b-col sm="5">
                            <label style="font-size: 14px;">سنة التولد :</label>
                        </b-col>
                        <b-col sm="7">
                            <b-form-input autocomplete="off" v-model="new_student.year_of_birth" type="text"></b-form-input>
                        </b-col>
                    </b-row>

                </b-col>
                <b-col>

                    <b-row class="my-3">
                        <b-col sm="5">
                            <label style="font-size: 14px;">تاريخ سنة المستجد</label>
                        </b-col>
                        <b-col sm="7">
                            <b-form-input autocomplete="off" v-model="new_student.first_year" type="text"></b-form-input>

                        </b-col>
                    </b-row>

                </b-col>

            </b-row>

            <b-row>
                <b-col>

                    <b-row class="my-3">
                        <b-col sm="5">
                            <label style="font-size: 14px;">الخانة :</label>
                        </b-col>
                        <b-col sm="7">
                            <b-form-input autocomplete="off" v-model="new_student.field_number" type="text"></b-form-input>
                        </b-col>
                    </b-row>

                </b-col>
                <b-col>

                    <b-row class="my-3">
                        <b-col sm="5">
                            <label style="font-size: 14px;">شعبة التجنيد :</label>
                        </b-col>
                        <b-col sm="7">
                            <b-form-input :disabled="new_student.gender == 'انثى'" autocomplete="off"
                                v-model="new_student.recruitment_division" type="text"></b-form-input>
                        </b-col>
                    </b-row>

                </b-col>

            </b-row>
            <b-row>
                <b-col>

                    <b-row class="my-3">
                        <b-col sm="5">
                            <label style="font-size: 14px;">المدينة :</label>
                        </b-col>
                        <b-col sm="7">
                            <b-form-input autocomplete="off" v-model="new_student.city" type="text"></b-form-input>
                        </b-col>
                    </b-row>

                </b-col>
                <b-col>


                    <b-row class="my-3">
                        <b-col sm="5">
                            <label style="font-size: 14px;">العنوان :</label>
                        </b-col>
                        <b-col sm="7">
                            <b-form-input autocomplete="off" v-model="new_student.address" type="text"></b-form-input>
                        </b-col>
                    </b-row>

                </b-col>

            </b-row>
            <b-row>
                <b-col>
                    <b-row class="my-3">
                        <b-col sm="5">
                            <label style="font-size: 14px;">الجنسية :</label>
                        </b-col>
                        <b-col sm="7">
                            <b-form-input autocomplete="off" v-model="new_student.nationalty" type="text"></b-form-input>
                        </b-col>
                    </b-row>

                </b-col>
                <b-col>
                    <b-row class="my-3">
                        <b-col sm="5">
                            <b-button size="lg" :disabled="isLoading" @click.prevent="addStudent"
                                class="inline-button add-student">إضافة
                                طالب جديد</b-button>
                        </b-col>
                        <vue-ellipse-progress v-if="isLoading" class="mx-auto" :loading="true" :size="48"
                            color="var(--background-blueish1)" :thickness="'10%'" :line="'butt'" />
                    </b-row>

                </b-col>

            </b-row>
        </b-container>
    </div>
</template>

<script>
export default {
    data() {
        return {
            new_student: {
                first_name: '',
                father_name: '',
                mother_name: '',
                last_name: '',
                birth_place: '',
                gender: null,
                field_number: '',
                recruitment_division: '',
                city: '',
                address: '',
                nationalty: '',
                first_year: "",
                year_of_birth: "",
            },
            empty_student: {
                first_name: '',
                father_name: '',
                mother_name: '',
                last_name: '',
                birth_place: '',
                gender: null,
                field_number: '',
                recruitment_division: '',
                city: '',
                address: '',
                nationalty: '',
            },
            isLoading: false,
            gender_options: [
                {
                    value: null,
                    text: "يرجى اختيار جنس الطالب"
                },
                {
                    value: 'ذكر',
                    text: 'ذكر'
                },
                {
                    value: 'انثى',
                    text: 'انثى'
                },

            ]
        }
    },
    methods: {
        addStudent() {
            this.isLoading = true;
            axios.post('/api/add-new-student', this.new_student)
                .then((response) => {
                    let data = response.data;
                    if (data.code == 200) {
                        this.$toast.success(data.msg);
                    } else {
                        this.$toast.warning(data.msg);
                    }
                    this.isLoading = false;
                    this.new_student = {
                        ...this.empty_student
                    };
                })
                .catch((error) => {
                    console.error(error);
                    this.$toast.error('حدث خطأ ما يرجى المحاولة مرة اخرى');
                    this.isLoading = false;
                })
        }
    }
}
</script>

<style scoped>
.inner__form {
    height: 250px;
    width: 330px;
}

.add-student {
    width: 190px !important;
}
</style>
