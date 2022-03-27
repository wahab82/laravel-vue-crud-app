import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';

import Companies from '../components/company/Companies';
import CreateCompany from '../components/company/CreateCompany';
import EditCompany from '../components/company/EditCompany';
import ShowCompany from '../components/company/ShowCompany';

import Employees from '../components/employee/Employees';
import CreateEmployee from '../components/employee/CreateEmployee';
import EditEmployee from '../components/employee/EditEmployee';
import ShowEmployee from '../components/employee/ShowEmployee';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'companies',
        path: '/companies',
        component: Companies
    },
    {
        name: 'createcompany',
        path: '/companies/store',
        component: CreateCompany
    },
    {
        name: 'showcompany',
        path: '/companies/show/:id',
        component: ShowCompany
    },
    {
        name: 'editcompany',
        path: '/companies/edit/:id',
        component: EditCompany
    },
    {
        name: 'employees',
        path: '/employees',
        component: Employees
    },
    {
        name: 'createemployee',
        path: '/employees/store',
        component: CreateEmployee
    },
    {
        name: 'showemployee',
        path: '/employees/show/:id',
        component: ShowEmployee
    },
    {
        name: 'editemployee',
        path: '/employees/edit/:id',
        component: EditEmployee
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
