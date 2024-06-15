import {createRouter, createWebHashHistory} from 'vue-router'
import HomePage from "@/views/HomePage.vue";
import MapMarker from "@/views/MapMarker.vue";

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomePage
  },{
    path: '/map',
    name: 'map',
    component: MapMarker
  },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
