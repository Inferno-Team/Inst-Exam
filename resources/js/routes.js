import HomePage from './views/Home.vue'
import LoginPage from './views/LoginPage.vue'
import AdminPage from './views/AdminPage.vue'
import ModeratorCRUD from './views/admin_pages/ModeratorCRUD.vue'
import Dates from './views/admin_pages/Dates.vue'
import EmptyPage from './layouts/EmptyPage.vue'
import StudentYearSectionPage from './views/admin_pages/StudentYearSectionPage.vue'
import SectionModerator from './views/admin_pages/SectionModerator.vue'

import ModeratorPage from './views/ModeratorPage.vue'
import ModeratorSectionYearStudents from './views/moderator_pages/ModeratorSectionYearStudents.vue'
import AddCoursePage from './views/moderator_pages/AddCoursePage.vue'
import CoursePage from './views/moderator_pages/courses/CoursePage.vue'
import AddMark1Page from './views/moderator_pages/courses/AddMark1Page.vue'
import AddMark2Page from './views/moderator_pages/courses/AddMark2Page.vue'
export const routes = [{
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
                component: StudentYearSectionPage
            },
            {
                path: 'moderator-crud',
                name: 'moderator-crud',
                component: ModeratorCRUD
            },
            {
                path: 'section/:id',
                name: 'section',
                props: true,
                component: SectionModerator,
            },
            {
                name: 'dates',
                path: '/admin/dates',
                component: Dates
            },
        ]
    },
    {
        path: '/moderator',
        component: ModeratorPage,
        children: [{
                path: '',
                name: 'moderator-page',
                component: ModeratorSectionYearStudents
            },
            {
                path: 'add-course',
                name: 'add-course',
                component: AddCoursePage
            },
            {
                path: 'courses',
                name: 'courses',
                component: CoursePage
            },
            {
                path: 'add-mark1',
                name: 'add-mark1',
                component: AddMark1Page
            },
            {
                path: 'add-mark2',
                name: 'add-mark2',
                component: AddMark2Page
            },
            {
                path: 'generate-marks-report',
                name: 'marks-report',
                component: EmptyPage
            }
        ]
    }

];
