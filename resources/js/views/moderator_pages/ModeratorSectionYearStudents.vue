<template>
    <div style="height: 100%; overflow-y: scroll;">
        <div class="row h-100" v-if="this.isLoading">
            <vue-ellipse-progress class="m-auto" :loading="true" :size="48" color="var(--background-blueish1)"
                :thickness="'10%'" :line="'butt'" />
        </div>
        <div v-else>
            <x-section :section="section" />
        </div>
    </div>
</template>

<script>
import Section from '../../components/section/Section.vue';
export default {
    components: { 'x-section': Section },
    mounted() {
        this.getSectionYears();
    },
    data() {
        return {
            isLoading: true,
            section: [],
        }
    },
    methods: {
        getSectionYears() {
            axios.get('/api/get-my-section-student')
                .then((res) => {
                    this.section = res.data.section;
                    this.isLoading = false;
                }).catch((error) => {
                    this.isLoading = false;
                    console.error(error);
                })
        }
    }
}
</script>

<style scoped></style>
