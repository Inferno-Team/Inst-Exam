<template>
    <div class="dashboard">
        <sidebar-menu :menu="menu" @item-click="onItemClick" :rtl="true" :relative="true" />
        <div class="my-container">
            <router-view />
        </div>
        <div class="floating-container">
            <div class="floating-button" @click.prevent="logout">
                <!-- <md-icon class="p-4">logout</md-icon> -->
                <BIconArrowUpRightSquare variant="dark" style="margin-top: 10px;padding: 3px;"></BIconArrowUpRightSquare>
            </div>
        </div>
        <b-modal id="marks-modal" hide-footer title="تغيير حالة الطلاب">
            <div class="mx-auto">
                <b-container fluid>
                    <b-row class="my-3" style="justify-content: center;">
                        <b-col sm="7">
                            <p>هل تريد ان تغير حالة الطلاب ؟</p>
                        </b-col>
                    </b-row>
                    <b-row class="my-5" style="align-items: center;">
                        <b-button class="inline-button" @click.prevent="goToPage">انطلاق</b-button>
                        <b-button class="outline-button" @click.prevent="$bvModal.hide('marks-modal')">اغلاق</b-button>
                    </b-row>

                </b-container>
            </div>
        </b-modal>
    </div>
</template>

<script>
import { CONSTANCES } from '../utils'

export default {

    mounted() {
        const token = localStorage.getItem(CONSTANCES.TOKEN_NAME)
        if (token == null || token == undefined) {
            this.$router.push({
                name: 'login-page'
            });
            return;
        }
        axios.get('/api/dates')
            .then((res) => {
                let date = res.data.date;
                console.log(date.current);
                if (date.current == 'summer-holiday') {
                    this.menu.push({
                        title: "تغيير حالة الطلاب",
                        icon: "fa fa-clock-o",
                    },);
                }
            })
            .catch(console.error);

    },
    data() {
        return {
            menu: [

                {
                    title: "عرض كافة الطلاب",
                    icon: "fa fa-university",
                    href: "/admin/",
                },
                {
                    title: 'ادارة مشرفي السنوات',
                    icon: 'fa fa-shield',//<i class="fa-solid fa-user-shield"></i>
                    href: '/admin/moderator-crud',
                },
                {
                    title: "تحديد تواريخ",
                    icon: "fa fa-clock-o",
                    href: "/admin/dates",
                },

            ]
        }
    },
    methods: {
        logout() {
            axios.defaults.headers.common['Authorization'] = ``;
            localStorage.removeItem(CONSTANCES.TOKEN_NAME);
            window.location.href = "/login";
        },
        onItemClick(event, item, node) {
            if (item.title === "تغيير حالة الطلاب") {
                this.$bvModal.show('marks-modal')
            }
        },
        goToPage() {
            axios.post('/api/change-student-status')
                .then((res) => {
                    let data = res.data;
                    if (data.code == 200)
                        this.$toast.success(data.msg);
                    else
                        this.$toast.warring(data.msg);
                    this.$bvModal.hide('marks-modal')

                })
                .catch((error) => {
                    console.log(error);
                    this.$toast.error('حدث خطأ ما');
                })
        }
    }
}
</script>

<style >
.dashboard {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.dashboard .my-container {
    width: 100%;
    height: 100%;
    background: #ccc;
}

.v-sidebar-menu .vsm--toggle-btn::after {
    content: "\f03a" !important;
    font-family: "FontAwesome" !important;
}

.v-sidebar-menu .vsm--arrow::after {
    content: "\f060" !important;
    font-family: "FontAwesome" !important;
}
</style>
