
import HomePage from './views/Home.vue'
import LoginPage from './views/LoginPage.vue'
import AdminPage from './views/AdminPage.vue'
import ModeratorCRUD from './views/admin_pages/ModeratorCRUD.vue'
import Dates from './views/admin_pages/Dates.vue'
import EmptyPage from './layouts/EmptyPage.vue'
export const routes = [
    {
        path: '/',
        name: 'home-page',
        component: HomePage
    },
    {
        path: '/login',
        name: 'login-page',
        component: LoginPage
    },
    {
        path: '/admin',
        component: AdminPage,
        children: [
            {
                path: '',
                name: 'admin-page',
                component: EmptyPage
            },
            {
                path: 'all-student',
                name: 'all-student',
                component: EmptyPage
            },
            {
                path: 'moderator-crud',
                name: 'moderator-crud',
                component: ModeratorCRUD
            },
            {
                path: 'add.course',
                name: 'add-course',
                component: EmptyPage
            },
            {
                name: 'dates',
                path: '/admin/dates',
                component: Dates
            },
        ]
    },

];
