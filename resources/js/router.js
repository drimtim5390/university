import VueRouter from 'vue-router'

import TimeTable from './pages/TimeTable.vue';
import SubjectsPage from './pages/SubjectsPage.vue';
import TeachersPage from './pages/TeachersPage.vue';

const routes = [
    {
        path: '/', component: TimeTable, name: 'timetable'
    },
    {
        path: '/subjects', component: SubjectsPage, name: 'subjects'
    },
    {
        path: '/teachers', component: TeachersPage, name: 'teachers'
    }
]

const router = new VueRouter({
    history: true,
    mode: 'history',
    routes
})
export default router
