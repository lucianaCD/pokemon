
const routes = [
    { 
        path: '/about',
        component: () => import('../pages/about.vue'),
        name: 'about'
    },
    { 
        path: '/',
        component: () => import('../components/pokemons.vue'),
        name: 'pokemons'
    },
]

export default routes;