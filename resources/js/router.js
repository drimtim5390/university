import VueRouter from 'vue-router'

import TimeTable from './pages/TimeTable.vue';
import GroupsPage from './pages/GroupsPage.vue';
import TeachersPage from './pages/TeachersPage.vue';
import SubjectsPage from './pages/SubjectsPage.vue';

const routes = [
    {
        path: '/', component: TimeTable, name: 'timetable'
    },
    {
        path: '/groups', component: GroupsPage, name: 'groups'
    },
    {
        path: '/teachers', component: TeachersPage, name: 'teachers'
    },
    {
        path: '/subjects', component: SubjectsPage, name: 'subjects'
    }
]

const router = new VueRouter({
    history: true,
    mode: 'history',
    routes
})
export default router
