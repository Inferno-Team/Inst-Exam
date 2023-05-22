<template>
    <div style="height: 100%;">
        <div class="report-container">
            <x-section v-for="(item, index) in sections" :key="index" @section-click="onSectionClicked" :index="index"
                :data="item" />
            <x-section @section-click="openAddSectionModal" :index="'-1'" />

        </div>

        <b-modal @hide="() => new_section = empty_new_section" id="add-section" hide-footer title="إضافة قسم">
            <b-container fluid>
                <p> إضافة قسم جديد</p>
                <b-row class="my-3">
                    <b-col sm="4">
                        <label style="font-size: 14px;">اسم القسم :</label>
                    </b-col>
                    <b-col sm="8">
                        <b-form-input autocomplete="off" v-model="new_section.name" type="text"></b-form-input>
                    </b-col>
                </b-row>

                <b-row class="my-5" style="align-items: center;">
                    <b-button class="inline-button" @click.prevent="addSection">إضافة</b-button>
                    <b-button class="outline-button" @click.prevent="$bvModal.hide('add-section')">إلغاء</b-button>
                </b-row>
            </b-container>
        </b-modal>
    </div>
</template>

<script>
import Section from '../../components/Section.vue';
export default {
    components: { 'x-section': Section },
    mounted() {

        axios.get('/api/sections')
            .then((res) => {
                this.sections = res.data.sections;

            })
            .catch(console.error);

    },
    data() {
        return {
            sections: [],
            empty_new_section: {
                name: ''
            },
            new_section: {
                name: ''
            }
        }
    },
    methods: {

        onSectionClicked(index) {
            this.$router.push({
                name: 'section',
                params: {
                    id: this.sections[index].id
                }
            })
        },

        openAddSectionModal(index) {
            this.$bvModal.show('add-section');
        },
        addSection() {
            axios.post('/api/add-section', {
                name: this.new_section.name
            })
            .then((response)=>{
                let data = response.data;
                this.$toast.success(data.msg);
                this.sections.push(data.section);

            })
            .catch((error)=>{
                this.$toast.error('حصل خطأ ما يرجى المحاولة مرة ثانية');
                console.log(error);
            })

            this.$bvModal.hide('add-section');
        }
    },

}
</script>

<style scoped>
.report-container {
    display: grid;
    grid-template-columns: repeat(2, minmax(92px, 0.5fr));
    justify-items: center;
    gap: 10px;
    height: 99%;
    overflow-y: auto;
}
</style>
