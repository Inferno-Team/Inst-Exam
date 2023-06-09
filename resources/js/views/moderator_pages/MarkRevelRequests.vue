<template>
    <div>
        <div class="bg-white m-3 p-3 rounded">
            <h4 class=""> الطلبات</h4>
            <b-table :fields="fields" @row-clicked="onRequestClicked" id="my-table" :per-page="perPage"
                :current-page="currentPage" striped hover :items="requests"></b-table>
            <b-pagination class="mt-4" style="justify-content: center;" v-model="currentPage" :total-rows="rows"
                :per-page="perPage" aria-controls="my-table"></b-pagination>


        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        axios.get("/api/get-all-requests")
            .then((response) => {
                let data = response.data;
                if (data.code == 200) {
                    this.requests = data.requests.map((request) => {
                        let d = new Date()
                        d.setTime(request.date_financial_receipt)
                        console.log(`date is :${d}`);
                        let date = `${d.getFullYear()}-${d.getMonth()}-${d.getDay()}`
                        return {
                            id: request.id,
                            no_financial_receipt: request.no_financial_receipt,
                            student_name: `${request.student.user.first_name} ${request.student.user.last_name}`,
                            student_univ_id: request.student.univ_id,
                            date_financial_receipt: date
                        }
                    });
                }
            })
    },
    data() {
        return {
            perPage: 8,
            currentPage: 1,
            requests: [],
            fields: [

                {
                    key: "id",
                    label: "تسلسل",
                },
                {
                    key: "student_name",
                    label: "اسم الطالب",
                },
                {
                    key: "student_univ_id",
                    label: "رقم الجامعي",
                },
                {
                    key: "no_financial_receipt",
                    label: "رقم الوصل المالي",
                },
                {
                    key: "date_financial_receipt",
                    label: "تاريخ الوصل المالي",
                },
            ]
        }
    },
    methods: {
        onRequestClicked(request, index) {
            this.$router.push({
                name: 'mark-report',
                params: {
                    id: request.id,
                }
            })
        }
    }
}
</script>

<style scoped></style>
