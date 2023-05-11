<template>
    <div style="height: 100%;">
        <div class="report-container">
            <x-section v-for="(item, index) in sections" @section-click="onSectionClicked" :key="index" :data="item"
                :index="index" />
        </div>
    </div>
</template>

<script>
import Section from '../../components/Section.vue';
export default {
    components: {  'x-section': Section },
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
