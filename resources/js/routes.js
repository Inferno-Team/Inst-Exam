
import HomePage from './views/home.vue'
import LoginPage from './views/LoginPage.vue'
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
    }
];