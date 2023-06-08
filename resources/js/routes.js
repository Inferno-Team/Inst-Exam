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
import AddNewStudentPage from './views/moderator_pages/AddNewStudentPage.vue'
import MarkRevelRequests from "./views/moderator_pages/MarkRevelRequests.vue"
import MarkReportPage from './views/moderator_pages/reports/MarkReportPage.vue'

import StudentPage from './views/StudentPage.vue'
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
            {
                name: 'change-student-status',
                path: '/admin/change-student-status',
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
                path: 'add-mark1/:id',
                name: 'add-mark-1',
                component: AddMark1Page,
                props: true
            },
            {
                path: 'add-mark2/:id',
                name: 'add-mark2',
                component: AddMark2Page,
                props: true
            },
            {
                path: 'generate-marks-report',
                name: 'marks-report',
                component: EmptyPage
            },
            {
                path: 'add-student',
                name: 'add-student',
                component: AddNewStudentPage
            },
            {
                path: 'requests',
                name: 'requests',
                component: MarkRevelRequests
            },
            {
                path:'mark-report/:id',
                name:'mark-report',
                component:MarkReportPage,
                props:true

            }
        ]
    },
    {
        path: '/student',
        component: StudentPage,
        name: 'student-page',
    }

];
