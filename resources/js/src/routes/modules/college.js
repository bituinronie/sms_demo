import Program from '../../views/college/program/Program'
import Subject from '../../views/college/subject/Subject'

import CurriculumList from '../../views/college/curriculum/Curriculum'
import CurriculumForm from '../../views/college/curriculum/CurriculumForm'

import Section from '../../views/college/section/Section'

import Schedule from '../../views/college/schedule/Schedule'
import ScheduleForm from '../../views/college/schedule/ScheduleForm'


export default [{
        path: '/college/programs',
        component: Program,
        name: 'Program',
        meta: {
            name: 'Program',
            route: '/college/programs',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    },
    {
        path: '/college/subjects',
        component: Subject,
        name: 'Subject (College)',
        meta: {
            name: 'Subject',
            route: '/college/subjects',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    },
    {
        path: '/college/curriculums',
        component: CurriculumList,
        name: 'Curriculum (College)',
        meta: {
            name: 'Curriculum',
            route: '/college/curriculums',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    },
    {
        path: '/college/curriculums/create',
        component: CurriculumForm,
        name: 'Create Curriculum',
        meta: {
            rolesWithAccess: ['ALL_EMPLOYEE']
        }
    },
    {
        path: '/college/curriculums/:id/edit',
        component: CurriculumForm,
        name: 'Edit Curriculum',
        meta: {
            rolesWithAccess: ['ALL_EMPLOYEE']
        },
        props: true
    },
    {
        path: '/college/sections',
        component: Section,
        name: 'Section (College)',
        meta: {
            name: 'Section',
            route: '/college/sections',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    },
    {
        path: '/college/schedules',
        component: Schedule,
        name: 'Schedule (College)',
        meta: {
            name: 'Schedule',
            route: '/college/schedules',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    },
    {
        path: '/college/schedules/:id/create',
        component: ScheduleForm,
        name: 'Create Schedule (College)',
        meta: {
            rolesWithAccess: ['ALL_EMPLOYEE']
        }
    },
     {
        path: '/college/schedules/:id/edit',
        component: ScheduleForm,
        name: 'Edit Schedule (College)',
        meta: {
            rolesWithAccess: ['ALL_EMPLOYEE']
        }
    },
]
