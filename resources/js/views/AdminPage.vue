<template>
    <div class="dashboard">
        <sidebar-menu :menu="menu" :rtl="true" :relative="true" />
        <div class="my-container">
            <router-view />
        </div>
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

    },
    data() {
        return {
            menu: [
                {
                    header: false,
                    title: "الصفحة الرئيسية",
                    icon: "fa fa-bars",
                    href: "/admin/",
                },
                {
                    title: "عرض كافة الطلاب",
                    icon: "fa fa-university",
                    href: "/admin/all-student",
                },
                {
                    title: 'ادارة مشرفي السنوات',
                    icon: 'fa fa-shield',//<i class="fa-solid fa-user-shield"></i>
                    href: '/admin/moderator-crud',
                },
                {
                    title: "إضافة مادة",
                    icon: "fa fa-pencil-square-o",
                    href: "/admin/add.course",
                },
                {
                    title: "تحديد تواريخ",
                    icon: "fa fa-clock-o",
                    href: "/admin/dates",
                },
            ]
        }
    },
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
