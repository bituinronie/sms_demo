import Login from '../../views/auth/Login'
import ChangePassword from '../../views/auth/ChangePassword'
import ForgotPassword from '../../views/auth/ForgotPassword'

export default [
    {
        path: "/login",
        component: Login,
        name: "Login",
        meta: {
            rolesWithAccess: ['GUEST']
        }
    },
    {
        path: '/account/change-password',
        component: ChangePassword,
        name: 'Change Password',
        meta: {
            rolesWithAccess: ['ALL_EMPLOYEE']
        }
    },
    {
        path: '/forgot-password',
        component: ForgotPassword,
        name: 'Forgot Password',
        meta: {
            rolesWithAccess: ['GUEST']
        }
    },
 ]