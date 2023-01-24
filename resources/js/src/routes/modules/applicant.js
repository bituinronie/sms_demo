import Applicant from "../../views/admission/applicant/Applicant";
import ApplicantList from "../../views/admission/applicant-list/ApplicantList";
import ApplicantForm from "../../views/admission/form/ApplicantForm";
import ApplicantRegistrationPrompt from "../../views/admission/form/ApplicantRegistrationPrompt";

export default [
    {
        path: "/applicants/create",
        component: ApplicantForm,
        name: "Create Applicant",
    },
    {
        path: "/applicants/create/:id",
        component: ApplicantRegistrationPrompt,
        name: "Success Applicant",
    },
    {
        path: "/applicants",
        component: ApplicantList,
        name: "Applicant",
        meta: {
            rolesWithAccess: ['ALL_EMPLOYEE']
        }
    },
    {
        path: '/applicants/:id/edit',
        component: ApplicantForm,
        name: 'Edit Applicant',
        meta: {
            rolesWithAccess: ['ALL_EMPLOYEE']
        }
    },
    {
        path: '/applicants/:id',
        component: Applicant,
        name: 'View Applicant',
        meta: {
            rolesWithAccess: ['ALL_EMPLOYEE']
        }
    },
]