import Vue from "vue";
import VueRouter from "vue-router";

import {
    auth
} from '../utils/auth'

Vue.use(VueRouter);

import LandingPage from '../views/LandingPage'
import Dashboard from "../views/Dashboard";
import PageNotFound from "../views/PageNotFound"

import authRoutes from './modules/auth'
import applicantRoutes from './modules/applicant'
import studentPortalRoutes from './modules/student_portal'
import accountingRoutes from './modules/accounting'
import collegeRoutes from './modules/college'
import basicEducationRoutes from './modules/basic_education'
import facilityRoutes from './modules/facility'
import systemRoutes from './modules/system'
import employeeRoutes from './modules/employee'
import userRoutes from './modules/user'


const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            component: LandingPage,
            name: "Landing Page",
            meta: {
                rolesWithAccess: ['GUEST']
            }
        },
        {
            path: "/dashboard",
            component: Dashboard,
            name: "Dashboard",
            meta: {
                rolesWithAccess: ['ALL_EMPLOYEE']
            }
        },
        ...authRoutes,
        ...applicantRoutes,
        ...studentPortalRoutes,
        ...accountingRoutes,
        ...collegeRoutes,
        ...basicEducationRoutes,
        ...facilityRoutes,
        ...systemRoutes,
        ...employeeRoutes,
        ...userRoutes,
        {
            path: "*",
            component: PageNotFound
        },
    ]
});

router.beforeEach((to, from, next) => {
    if (to.meta && to.meta.rolesWithAccess) {
        let rolesWithAccess = to.meta.rolesWithAccess
        if (rolesWithAccess.includes('GUEST')) {
            if (auth.isEmployee()) {
                next({name: 'Dashboard'})
            }
            else if (auth.isStudent()) {
                next({name: 'Student Dashboard'})
            } else {
                next()
            }
        } else if (rolesWithAccess.includes('ALL_USER')) {
            if (auth.isEmployee() || auth.isStudent()) {
                next()   
            } else {
                next({name: 'Landing Page'})
            }
        } else if (rolesWithAccess.includes('ALL_EMPLOYEE')) {
            if (auth.isEmployee()) {
                next()   
            } else {
                next({name: 'Landing Page'})
            }
        } else {
            if (auth.auth() && auth.auth().accountRole) {
                let roles = auth.auth().accountRole
                if (rolesWithAccess.some(role => roles.includes(role))) {
                    next()
                } else {
                    next({name: 'Landing Page'})
                }
            } else {
                next({name: 'Landing Page'})
            }
        }
    } else {
        next()
    }
})

export default router;
