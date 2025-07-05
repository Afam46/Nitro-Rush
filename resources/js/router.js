import { createRouter, createWebHistory } from "vue-router";
import Home from "./components/pages/Home.vue";
import Market from "./components/pages/Market.vue";
import Races from "./components/pages/Races.vue";
import RaceGame from "./components/pages/RaceGame.vue";
import Login from "./components/pages/Login.vue";
import Register from "./components/pages/Register.vue";
import Preparation from "./components/pages/Preparation.vue";
import Shop from "./components/pages/Shop.vue";

const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    },
    {
        path: '/',
        name: 'home',
        component: Home,
    },
    {
        path: '/market',
        name: 'market',
        component: Market,
    },
    {
        path: '/shop',
        name: 'shop',
        component: Shop,
    },
    {
        path: '/races',
        name: 'races',
        component: Races,
    },
    {
        path: '/raceGame/:raceId/:carId',
        name: 'raceGame',
        component: RaceGame,
    },
    {
        path: '/preparation/:id',
        name: 'prep',
        component: Preparation,
    }
];

const router = createRouter({
    history : createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const isAuth = localStorage.getItem('isAuth');
    if(!isAuth){
        if(to.name === 'login' || to.name === 'register'){
            return next()
        }else{
            return next({
                name: 'login'
            })
        }
    }
    if(to.name === 'login' || to.name === 'register' && isAuth){
        return next({
            name: 'account'
        })
    }

    next()
})

export default router;