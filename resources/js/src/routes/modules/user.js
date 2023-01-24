import User from '../../views/system/user/User'
import EmployeeUserList from '../../views/system/user/employee/Employee'
import StudentUserList from '../../views/system/user/student/Student'

export default [{
        path: '/users',
        component: User,
        name: 'User',
        meta: {
            rolesWithAccess: ['ALL_EMPLOYEE'],
            route: ''
        }
    },
    {
        path: '/user/employees',
        component: EmployeeUserList,
        name: 'User (Employee)',
        meta: {
            name: 'User',
            route: 'department/information-technology-services/account/user',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    },
    {
        path: '/user/students',
        component: StudentUserList,
        name: 'User (Student)',
        meta: {
            name: 'User',
            route: 'department/information-technology-services/account/student',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    },
]
