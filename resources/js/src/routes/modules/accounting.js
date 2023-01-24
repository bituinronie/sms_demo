import ProofOfPayment from '../../views/accounting/proof-of-payment/ProofOfPayment';


export default [
    {
        path: '/accounting/payment/proof-of-payments',
        component: ProofOfPayment,
        name: 'Proof of Payment',
        meta: {
            name: 'Proof of Payment',
            route: '/accounting/payments',
            rolesWithAccess: ['ALL_EMPLOYEE'],
        }
    }
 ]