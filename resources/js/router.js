import VueRouter from 'vue-router'

import TimeTable from './pages/TimeTable.vue';
import GroupsPage from './pages/GroupsPage.vue';
import RoomsPage from './pages/RoomsPage.vue';
import SubjectsPage from './pages/SubjectsPage.vue';
import TeachersPage from './pages/TeachersPage.vue';

const routes = [
    {
        path: '/', component: TimeTable, name: 'timetable'
    },
    {
        path: '/groups', component: GroupsPage, name: 'groups'
    },
    {
        path: '/rooms', component: RoomsPage, name: 'rooms'
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
