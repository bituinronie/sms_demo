import Building from '../../views/facility/building/Building'
import Room from '../../views/facility/room/Room'
import Laboratory from '../../views/facility/laboratory/Laboratory'

export default [{
        path: '/facility/buildings',
        component: Building,
        name: 'Building',
        meta: {
            name: 'Building',
            route: '/facility/buildings',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    },
    {
        path: '/facility/rooms',
        component: Room,
        name: 'Room',
        meta: {
            name: 'Room',
            route: '/facility/rooms',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    },
    {
        path: '/facility/laboratories',
        component: Laboratory,
        name: 'Laboratory',
        meta: {
            name: 'Laboratory',
            route: '/facility/laboratories',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    },
]
