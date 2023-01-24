import Login from '../../views/auth/Login'
import ChangePassword from '../../views/auth/ChangePassword'
import Dashboard from '../../views/Dashboard'
import Profile from '../../views/student-portal/Profile'
import ProofOfPayment from '../../views/student-portal/proof-of-payment/ProofOfPayment'

export default [
    {
        path: '/portal/login',
        component: Login,
        name: 'Student Login',
        meta: {
            rolesWithAccess: ['GUEST']
        }
    },
    {
        path: '/portal/dashboard',
        component: Dashboard,
        name: 'Student Dashboard',
        meta: {
            rolesWithAccess: ['STUDENT']
        }
    },
    {
        path: '/portal/profile',
        component: Profile,
        name: 'Student Profile',
        meta: {
            rolesWithAccess: ['STUDENT']
        }
    },
    {
        path: '/portal/payment/proof-of-payments',
        component: ProofOfPayment,
        name: 'Student Proof of Payment',
        meta: {
            rolesWithAccess: ['STUDENT']
        }
    },
    {
        path: '/portal/account/change-password',
        component: ChangePassword,
        name: 'Student Change Password',
        meta: {
            rolesWithAccess: ['STUDENT']
        }
    },
]