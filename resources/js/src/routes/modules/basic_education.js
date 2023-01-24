import Strand from '../../views/basic-education/strand/Strand'
import Curriculum from '../../views/basic-education/curriculum/Curriculum'
import Section from '../../views/basic-education/section/Section'

export default [
    {
        path: '/basic-education/strands',
        component: Strand,
        name: 'Strand',
        meta: {
            name: 'Strand',
            route: '/basiceducation/strands',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    },
    {
        path: '/basic-education/sections',
        component: Section,
        name: 'Section (Basic Education)',
        meta: {
            name: 'Section',
            route: '/college/sections',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    },
    {
        path: '/basic-education/curriculums',
        component: Curriculum,
        name: 'Curriculum (Basic Education)',
        meta: {
            name: 'Curriculum',
            route: '/college/curriculums',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    },
 ]