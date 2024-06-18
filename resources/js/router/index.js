import {createRouter, createWebHashHistory} from 'vue-router'
import HomePage from "@/views/HomePage.vue";
import MapMarker from "@/views/MapMarker.vue";
import RGPD from "../views/RGPD.vue";

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomePage
  },{
    path: '/map',
    name: 'map',
    component: MapMarker
  },{
    path: '/policy',
    name: 'policy',
    component: RGPD
  },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
