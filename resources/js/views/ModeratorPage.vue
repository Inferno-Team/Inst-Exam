<template>
    <div class="dashboard">
        <sidebar-menu :menu="menu" :rtl="true" :relative="true" />
        <div class="my-container">
            <router-view />
        </div>
        <div class="floating-container">
            <div class="floating-button" @click.prevent="logout">
                <!-- <md-icon class="p-4">logout</md-icon> -->
                <BIconArrowUpRightSquare variant="dark" style="margin-top: 10px;padding: 3px;"></BIconArrowUpRightSquare>
            </div>
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
                    title: "عرض كافة الطلاب",
                    icon: "fa fa-university",
                    href: "/moderator/",
                },
                {
                    title: 'إضافة مادة',
                    icon: 'fa fa-shield',//<i class="fa-solid fa-user-shield"></i>
                    href: '/moderator/add-course',
                },
                {
                    title: 'المواد',
                    icon: 'fa fa-shield',//<i class="fa-solid fa-user-shield"></i>
                    href: '/moderator/courses',
                },
                /* {
                    title: 'إضافة علامات عملي',
                    icon: 'fa fa-shield',//<i class="fa-solid fa-user-shield"></i>
                    href: '/moderator/add-mark1',
                },
                {
                    title: 'إضافة علامات نظري',
                    icon: 'fa fa-shield',//<i class="fa-solid fa-user-shield"></i>
                    href: '/moderator/add-mark2',
                },
                {
                    title: 'إنشاء كشف علامات',
                    icon: 'fa fa-shield',//<i class="fa-solid fa-user-shield"></i>
                    href: '/moderator/generate-marks-report',
                },
 */

            ]
        }
    },
    methods: {
        logout() {
            axios.defaults.headers.common['Authorization'] = ``;
            localStorage.removeItem(CONSTANCES.TOKEN_NAME);
            window.location.href = "/login";
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
