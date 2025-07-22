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
        path: '/raceGame',
        name: 'raceGame',
        component: RaceGame,
        meta: { requiresAuth: true }
    },
    {
        path: '/preparation',
        name: 'prep',
        component: Preparation,
    }
];

const router = createRouter({
    history : createWebHistory(),
    routes
});

router.beforeEach(async (to, from, next) => {
  const token = localStorage.getItem('auth_token');
  const isAuthRoute = to.name === 'login' || to.name === 'register';
  
  if (!token) {
    if (isAuthRoute) {
      return next();
    }
    return next({ name: 'login' })
  }

  if (isAuthRoute) {
    return next({ name: 'home' })
  }

  try {
    await axios.get('/api/user', {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
    next();
  } catch (error) {
    localStorage.removeItem('auth_token');
    if (!isAuthRoute) {
      return next({ name: 'login' });
    }
    next();
  }
})

export default router;