<template>
    <div class="bg-white m-3 p-3 rounded"  >
        <h4 style="width: 20rem;"> القسم : {{ section.name }} </h4>
        <SectionYear v-for="(year, index) in section.years" :key="index" :year="year" />
    </div>
</template>

<script>
import SectionYear from './SectionYear.vue';

export default {
    name: "x-section",
    props: ["section"],
    components: { SectionYear }
}
</script>

<style  scoped>

</style>
