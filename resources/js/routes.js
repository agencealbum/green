import Scan from './components/Scan.vue';
import Faq from './components/Faq.vue';
import Contact from './components/Contact.vue';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Scan,
        props: true,
    },
    {
        name: 'faq',
        path: '/faq',
        component: Faq
    },
    {
        name: 'contact',
        path: '/contact',
        component: Contact
    }
];