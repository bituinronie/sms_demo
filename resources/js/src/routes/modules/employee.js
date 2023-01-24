import EmployeeList from '../../views/employee/list/Employee'
import EmployeeForm from '../../views/employee/form/EmployeeForm';
import EmployeeView from '../../views/employee/view/EmployeeView'

export default [{
        path: '/human-resource/employees',
        component: EmployeeList,
        name: 'Employee',
    meta: {
            name: 'Employee',
            route: '/human-resource/employees',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    },
    {
        path: '/human-resource/employees/create',
        component: EmployeeForm,
        name: 'Create Employee',
        meta: {
            rolesWithAccess: ['ALL_EMPLOYEE']
        }
    },
    {
        path: '/human-resource/employees/:id',
        component: EmployeeView,
        name: 'View Employee',
        meta: {
            rolesWithAccess: ['ALL_EMPLOYEE']
        }
    },
    {
        path: '/human-resource/employees/:id/edit',
        component: EmployeeForm,
        name: 'Edit Employee',
        meta: {
            rolesWithAccess: ['ALL_EMPLOYEE']
        }
    },

]
