import Scan from './components/Scan.vue';
import Faq from './components/Faq.vue';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Scan
    },
    {
        name: 'faq',
        path: '/faq',
        component: Faq
    }
];