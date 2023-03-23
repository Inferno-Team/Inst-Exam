<template>
    <div style="height: 100%; display: flex; justify-content: center">
        <div class="table-container" v-if="moderators.length > 0 && isLoaded">
            <div style="display: flex;align-content: end;flex-wrap: wrap;flex-direction: column;margin-top: 5rem;">
                <b-button v-if="yearsLoaded" @click.prevent="openAddModal" class="inline-button"
                    style="width: 210px !important;">
                    إضافة مشرف سنة جديد
                    <b-icon icon="plus-lg" />
                </b-button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th scope="row">ت</th>
                        <th scope="row">اسم المشرف</th>
                        <th scope="row">الكنية</th>
                        <th scope="row">رقم الهاتف</th>
                        <th scope="row">تاريخ التعيين</th>
                        <th scope="row">السنة</th>
                        <td colspan="2">عمليات</td>
                    </tr>
                </thead>
                <tbody>
                    <moderator-item v-for="(moderator, i) in moderators" :key="i" :moderator="moderator" :index="i"
                        @edit="editModal" @remove="showRemoveModal" />

                </tbody>
            </table>
        </div>
        <div class="mx-auto my-auto" style="height: 50px ;" v-else-if="!isLoaded">
            <vue-ellipse-progress class="mx-auto" :loading="true" :size="48" color="var(--background-blueish1)"
                :thickness="'10%'" :line="'butt'" />
        </div>
        <div v-else class="no-moderators-container my-auto">
            <p>لا يوجد اي مشرف سنوات حاليا يرجى اضافة مشرف سنة من هنا</p>
            <b-button v-if="yearsLoaded" v-b-modal.moderator-modal class="inline-button" style="width: 210px !important;">
                إضافة مشرف سنة جديد
                <b-icon icon="plus-lg" />
            </b-button>
        </div>
        <b-modal id="moderator-modal" @hide="cleanField" hide-footer :title="modalTitle">
            <div class="mx-auto">
                <b-container fluid>
                    <b-row class="my-3" style="justify-content: center;">
                        <b-col sm="7">
                            <b-form-select v-model="selectedYear" :options="years"></b-form-select>
                        </b-col>
                    </b-row>
                    <b-row class="my-3" v-if="selectedYear != null">
                        <b-col sm="4">
                            <label style="font-size: 14px;">اسم المشرف :</label>
                        </b-col>
                        <b-col sm="8">
                            <b-form-input :state="firstNameState" aria-describedby="first-name-live-feedback"
                                v-model="newModerator.first_name" type="text"></b-form-input>
                            <b-form-invalid-feedback id="first-name-live-feedback">
                                {{ errors.name == undefined ? '' : errors.name }}
                            </b-form-invalid-feedback>
                        </b-col>
                    </b-row>

                    <b-row class="my-3" v-if="selectedYear != null">
                        <b-col sm="4">
                            <label style="font-size: 14px;">كنية المشرف :</label>
                        </b-col>
                        <b-col sm="8">
                            <b-form-input :state="lastNameState" aria-describedby="last-name-live-feedback"
                                v-model="newModerator.last_name" type="text"></b-form-input>
                            <b-form-invalid-feedback id="last-name-live-feedback">
                                {{ errors.last_name == undefined ? '' : errors.last_name }}
                            </b-form-invalid-feedback>
                        </b-col>
                    </b-row>

                    <b-row class="my-3" v-if="selectedYear != null">
                        <b-col sm="4">
                            <label style="font-size: 14px;">رقم هاتف المشرف :</label>
                        </b-col>
                        <b-col sm="8">
                            <b-form-input :state="phoneState" aria-describedby="phone-live-feedback"
                                v-model="newModerator.phone_number" type="text"></b-form-input>
                            <b-form-invalid-feedback id="phone-live-feedback">
                                {{ errors.phone == undefined ? '' : errors.phone }}
                            </b-form-invalid-feedback>
                        </b-col>
                    </b-row>

                    <b-row class="my-3" v-if="selectedYear != null" style="align-items: center;">
                        <b-col sm="4">
                            <label style="font-size: 14px;">كملة سر المشرف :</label>
                        </b-col>
                        <b-col sm="7">
                            <b-form-input v-model="newModerator.password" :state="passwordState"
                                aria-describedby="password-live-feedback"
                                :type="showPassword ? 'text' : 'password'"></b-form-input>
                            <b-form-invalid-feedback id="password-live-feedback">
                                {{ errors.password == undefined ? '' : errors.password }}
                            </b-form-invalid-feedback>
                        </b-col>
                        <b-col sm="1">
                            <b-icon style="cursor: pointer;" size='48' :icon="showPassword ? 'eye-slash' : 'eye'"
                                @click="showPassword = !showPassword" />
                        </b-col>
                    </b-row>
                    <b-row class="my-5" v-if="selectedYear != null" style="align-items: center;">
                        <b-button class="inline-button"
                            @click.prevent="isEdit ? saveEditModerator() : addNewModerator()">حفظ</b-button>
                        <b-button class="outline-button" @click.prevent="cleanField">تفريغ الحقول</b-button>
                    </b-row>

                </b-container>
            </div>
        </b-modal>
        <b-modal @hide="cleanField" id="remove-moderator" hide-footer title="حذف مشرف">
            <b-container fluid>
                <p>هل تريد حقا حدث هذا المشرف [ {{ removeModalModerator.first_name }} ] ؟</p>
                <b-row class="my-5" style="align-items: center;">
                    <b-button class="inline-button" @click.prevent="removeModerator">نعم</b-button>
                    <b-button class="outline-button" @click.prevent="$bvModal.hide('remove-moderator')">كلا</b-button>
                </b-row>
            </b-container>
        </b-modal>

    </div>
</template>

<script>
import ModeratorItem from '../../components/ModeratorItem.vue';
export default {
    components: { ModeratorItem },
    mounted() {
        axios.get('/api/get-moderators')
            .then((res) => {
                let data = res.data;
                this.moderators = data.moderators;
                this.isLoaded = true;
            })
            .catch((err) => {
                console.error(err);
                this.$toast.error('حدث خطأ ما يرجى المحاولة مرة اخرى');
                this.isLoaded = true;
            });
        axios.get('/api/get-years')
            .then((res) => {

                this.years = res.data.years.map((year) => {
                    return {
                        text: year.name,
                        value: year,
                        disabled: year.moderator != null
                    };
                });
                this.years.unshift({
                    text: 'يرجى اختيار سنة لإضافة مشرف سنة عليه',
                    value: null,
                });
                this.yearsLoaded = true;
            }).catch((err) => {
                console.error(err);
                this.$toast.error('حدث خطأ ما يرجى المحاولة مرة اخرى');
                this.isLoaded = true;
            });

    },
    data() {
        return {
            moderators: [],
            isLoaded: false,
            yearsLoaded: false,
            selectedYear: null,
            years: [],
            showPassword: false,
            newModerator: {},
            backupModerator: {},
            errors: {},
            modalTitle: "إضافة مشرف جديد",
            removeModalModerator: {},
            isEdit: false,
            editIndex: 0,
        }
    },
    methods: {
        cleanField() {
            this.selectedYear = null;
            this.newModerator = {};
            this.errors = {};
            if (this.isEdit)
                this.moderators[this.editIndex] = { ...this.backupModerator };
            this.removeModalModerator = {};
            this.backupModerator = {};
            this.isEdit = false;
            this.modalTitle = "إضافة مشرف جديد";
        },
        addNewModerator() {
            if (this.newModerator.first_name == undefined)
                this.errors = {
                    ...this.errors,
                    name: 'هذا الحقل مطلوب'
                };
            if (this.newModerator.last_name == undefined)
                this.errors = {
                    ...this.errors,
                    last_name: 'هذا الحقل مطلوب'
                };
            if (this.newModerator.phone_number == undefined)
                this.errors = {
                    ...this.errors,
                    phone: 'هذا الحقل مطلوب'
                };
            if (this.newModerator.password == undefined)
                this.errors = {
                    ...this.errors,
                    password: 'هذا الحقل مطلوب'
                };
            if (Object.keys(this.errors).length == 0) {
                axios.post('/api/add-moderator', {
                    ...this.newModerator,
                    year_id: this.selectedYear.id,
                })
                    .then((res) => {
                        let data = res.data;
                        if (data.code == 200) {
                            this.moderators.push(data.moderator);
                            this.$toast.success(data.msg);
                            let index = 0;
                            for (let year of this.years) {
                                if (year.value != null)
                                    if (year.value.id == this.selectedYear.id)
                                        this.years[index].disabled = true;
                                index++;
                            }
                            this.$bvModal.hide('moderator-modal');
                        } else {
                            this.$toast.warning(data.msg);
                        }
                    })
                    .catch((error) => {
                        this.$toast.error('حدث خطأ ما');
                        console.log(error);
                    })
            }
        },
        editModal({ index, moderator, yearId }) {

            this.editIndex = this.moderators.indexOf(moderator);
            this.newModerator = moderator;
            this.backupModerator = { ...moderator };
            this.modalTitle = 'تعديل مشرف';
            console.log(index);
            this.years[index].disabled = false;
            for (let year of this.years) {
                console.log(yearId);
                if (year.value != null && year.value.id == yearId) {
                    this.selectedYear = year.value;

                    break;
                }
            }
            this.$bvModal.show('moderator-modal');
            this.isEdit = true;
        },
        saveEditModerator() {
            this.newModerator.year_id = this.selectedYear.id;
            axios.post('/api/edit-moderator', this.newModerator)
                .then((res) => {
                    let data = res.data;
                    if (data.code == 200) {
                        this.$toast.success(data.msg);
                        let moderator = data.moderator;
                        let ms = [];
                        for (let m of this.moderators)
                            if (m.id != moderator.id)
                                ms.push(m);
                            else {
                                ms.push(moderator);
                                this.backupModerator = moderator;
                            }
                        this.moderators = ms;
                        let index = 0;
                        for (let year of this.years) {
                            if (year.value != null) {
                                if (year.value.id == this.selectedYear.id)
                                    this.years[index].disabled = true;
                                if (year.value.id == this.newModerator.year.year_id)
                                    this.years[index].disabled = false;
                            }
                            index++;
                        }
                        this.$bvModal.hide('moderator-modal');
                    } else {
                        this.$toast.warning(data.msg);
                    }
                })
                .catch(console.error);
        },
        showRemoveModal({ index, moderator, yearId }) {
            this.removeModalModerator = moderator;
            this.$bvModal.show('remove-moderator');
        },
        removeModerator() {
            axios.post('/api/remove-moderator', { id: this.removeModalModerator.id })
                .then((res) => {
                    let data = res.data;
                    console.log(data);
                    if (data.code > 200 || data.code < 200) {

                        this.$toast.warning(data.msg);
                    } else {
                        this.$toast.success(data.msg);

                        let ms = [];
                        for (let mode of this.moderators) {
                            if (mode.id != this.removeModalModerator.id) {
                                ms.push(mode);
                            }
                        }
                        this.moderators = ms;
                        let index = 0;
                        for (let year of this.years) {
                            if (year.value != null) {
                                if (year.value.id == this.removeModalModerator.year.year_id) {
                                    this.years[index].disabled = false;
                                }

                            }
                            index++;
                        }
                        this.$bvModal.hide('remove-moderator');
                    }
                })
                .catch((error) => {
                    this.$toast.error('حدث خطأ ما');
                    console.log(error);
                })
        },
        openAddModal() {
            this.modalTitle = "إضافة مشرف جديد";
            this.$bvModal.show('moderator-modal');
            this.selectedYear = null;
            for (let year of this.years) {
                if (year.value == null) continue;
                if (year.value.moderator != null) year.disabled = true;

            }
        }
    },
    computed: {
        firstNameState() {
            return this.errors.name == undefined ? null : false;
        },
        lastNameState() {
            return this.errors.last_name == undefined ? null : false;
        },
        phoneState() {
            return this.errors.phone_number == undefined ? null : false;
        },
        passwordState() {
            return this.errors.password == undefined ? null : false;
        },

    }
}
</script>

<style scoped>
th,
td {
    border: 1px solid;
    padding: 0.5rem;
    text-align: center;
    font-weight: bold;
}

.table-container {
    overflow-y: auto;
    width: 88%;
}

table {
    width: 100%;
    margin-top: 10px;
    border-collapse: collapse;
}

.no-moderators-container {

    width: 300px;
    text-align: center;
    align-items: center;
    align-content: center;
    display: flex;
    flex-wrap: wrap;
    flex-direction: column;
}

.no-moderators-container p {
    font-size: 21px;
    color: black;

}
</style>
