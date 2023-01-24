import Branch from '../../views/system/branch/Branch'
import ActivityLogs from '../../views/system/activity-logs/ActivityLogs'
import Department from '../../views/system/department/Department'

export default [{
        path: '/system/branches',
        component: Branch,
        name: 'Branch',
        meta: {
            name: 'Branch',
            route: '/system/branches',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    },
    {
        path: '/system/activity-logs',
        component: ActivityLogs,
        name: 'Activity Logs',
        meta: {
            name: 'Activity Logs',
            route: '/system/activity-logs',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    },
    {
        path: '/system/departments',
        component: Department,
        name: 'Department',
        meta: {
            name: 'Department',
            route: '/department/departments',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    },
]
