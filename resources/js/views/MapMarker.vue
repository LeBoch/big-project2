<template>
  <!--Création de la map avec Leaflet-->
  <l-map
      :center="center"
      :zoom="zoom"
      ref="map"
      class="z-10"
  >
    <h1 class="hidden">Vélolibs</h1>
    <dt class="hidden">Explorer Montpellier avec les différents moyen de transport proposés comme les bus , les trams ,
      les vélos , ou les parkings de voiture
    </dt>
    <l-tile-layer :url="url" alt="Carte Intéractive"></l-tile-layer>
    <!--Si enabledBike est vrai alors on affiche les stations de vélos sur la map-->
    <template v-if="enabledBike">
      <!-- Bouclage sur les données récupérées avec l'api pour pouvoir placés les marqueurs-->
      <l-marker
          v-for="marker in markersBike"
          :key="marker.id"
          :lat-lng="[marker.lat , marker.lon ]"
      >
        <!--Mise en place de l'icon unique pour les stations de vélos-->
        <l-icon :icon-size="[35, 27]"
                icon-url="/img/parkVelo.png" alt="Icon pour l'emplacement des vélos">
        </l-icon>
        <!--Pop Up avec les donnéés des stations vélos-->
        <l-popup><h2>Nombre de vélo disponible : {{ marker.bike_available }} <br>
          Places disponible : {{ marker.nbr_available }} <br>
          Pourcentage de vélo restant : {{ marker.pct_available }} % <br>
          Refresh : {{ new Date(marker.updated_at).toLocaleDateString() }} à
          {{ new Date(marker.updated_at).toLocaleTimeString() }}
        </h2></l-popup>
      </l-marker>
    </template>

    <!--Si enabledCar est vrai alors on affiche les marqueurs des voitures-->
    <template v-if="enabledCar">
      <l-marker
          v-for="marker in markersCar"
          :key="marker.id"
          :lat-lng="[marker.lat , marker.lon ]"
      >
        <!--Mise en place des icons unique pour les voitures-->
        <l-icon :icon-size="[45, 35]"
                icon-url="/img/parkVoiture.png" alt="Icon pour l'emplacement des Parkings">
        </l-icon>
        <!--Mise en place des PopUps avec les données requises-->
        <l-popup>
          <h2>Nom Parking : {{ marker.name }} <br>
            Nombre de place de parkings disponible : {{ marker.nbr_space_available }} <br>
            Capacité : {{ marker.nbr_total_space }} <br>
            Véhicule autorisée :
            <template v-if="marker.authorized_car_type.includes(searchTermCar)">
              🚗
            </template>
            <template v-if="marker.authorized_car_type.includes(searchTermMoped)">
              🏍️
            </template> <br>
            Refresh : {{ new Date(marker.updated_at).toLocaleDateString() }} à
            {{ new Date(marker.updated_at).toLocaleTimeString() }}
          </h2>
        </l-popup>
      </l-marker>
    </template>
    <!--Si EnabledBus est vrai alors on affichage les marqueurs de l'emplacement des arrêts de bus -->
    <template v-if="enabledBus">
      <!--Mise en place du ClusterGroup pour les arrêts de bus -->
      <l-marker-cluster-group>
        <!--Affichage des marquerus pour les bus-->
        <l-marker
            v-for="marker in markersBus"
            :key="marker.id"
            :lat-lng="[marker.lat , marker.lon]"
        >
          <!--Affichage de la pop up pour les bus-->
          <l-popup>
            Nom Arret de Bus : {{ marker.name }} <br>
            Refresh : {{ new Date(marker.updated_at).toLocaleDateString() }} à
            {{ new Date(marker.updated_at).toLocaleTimeString() }} <br>
          </l-popup>
          <l-icon :icon-size="[45, 35]"
                  icon-url="/img/logoBus.png" alt="Icone pour les icons de bus">
          </l-icon>
        </l-marker>
      </l-marker-cluster-group>
    </template>
    <!--Si EnabledTram est vrai alors on affiche les informations sur les Trams-->
    <template v-if="enabledTram">
      <l-marker-cluster-group>
        <!--Affichage des marqueurs sur l'emplacement des arrêts de Trams-->
        <l-marker
            v-for="marker in markersTram"
            :key="marker.id"
            :lat-lng="[marker.lat , marker.lon ]">
          <!--Modification de l'icon des Trams-->
          <l-icon :icon-size="[50, 40]"
                  icon-url="/img/logoTram.png" alt="Icon pour les emplacements de tram">
          </l-icon>
          <!--Affichage de la POP UP avec les informations sur les trams-->
          <l-popup>
            <h2>Nom Arret : {{ marker.name }} <br>
              Refresh : {{ new Date(marker.updated_at).toLocaleDateString() }} à
              {{ new Date(marker.updated_at).toLocaleTimeString() }} <br></h2>
          </l-popup>
        </l-marker>
      </l-marker-cluster-group>
      <!--Affichage du tracés des lignes de trams-->
      <l-polyline
          v-for="(marker,i) in markersTramCoordinates.results"
          :key="i"
          :lat-lngs="marker.geo_shape.geometry.coordinates" :color='marker.code_coule'
      >
      </l-polyline>
    </template>
  </l-map>
  <div
      class="z-50 ml-4 w-60 rounded-md bg-neutral-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-neutral-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-neutral-400 px-3.5 py-2.5 sticky z-30 -mt-60 ">
    <div class="flex mb-2">
      <!--Toggle pour les parkings-->
      <Switch v-model="enabledCar"
              :class="[enabledCar ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2']">
        <span class="sr-only">Afficher les Places de Parkings</span>
        <span aria-hidden="true"
              :class="[enabledCar ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']"/>
      </Switch>
      <h2>Parking Voiture </h2>
    </div>

    <div class="flex mb-2">
      <!--Toggle pour les Stations de Vélos-->
      <Switch v-model="enabledBike"
              @click="refresh"
              :class="[enabledBike ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2']">
        <span class="sr-only">Afficher les stations Vélomagg</span>
        <span aria-hidden="true"
              :class="[enabledBike ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']"/>
      </Switch>
      <h2>Parking velo </h2>
    </div>

    <div class="flex mb-2">
      <!--Toggle pour les Arrêts de bus-->
      <Switch v-model="enabledBus"
              :class="[enabledBus ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2']">
        <span class="sr-only">Afficher les stations Bus</span>
        <span aria-hidden="true"
              :class="[enabledBus ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']"/>
      </Switch>
      <h2>Parking Bus </h2>
    </div>

    <div class="flex">
      <!--Toggle pour les Arrêts et Lignes de Tram-->
      <Switch v-model="enabledTram"
              :class="[enabledTram ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2']">
        <span class="sr-only">Afficher les stations de tram</span>
        <span aria-hidden="true"
              :class="[enabledTram ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']"/>
      </Switch>
      <h2> Parking Tram </h2>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue'
import {LPolyline, LIcon, LMap, LMarker, LPopup, LTileLayer} from '@vue-leaflet/vue-leaflet';
import {LMarkerClusterGroup} from "vue-leaflet-markercluster";
import 'leaflet/dist/leaflet.css';
import 'vue-leaflet-markercluster/dist/style.css'
import axios from "axios";
import {Switch} from '@headlessui/vue'

// URL de la map
const url = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'
// Faire en sorte que la map soit centrée sur montpellier
const center = ref([43.5974, 3.8820])
const zoom = ref(12)
// Données sur les stations de Vélos
const markersBike = ref([])
// Données sur les parkings
const markersCar = ref([])
// Données sur les arrêt de bus
const markersBus = ref([])
// Données des arrêts de tram
const markersTram = ref([])
// Donnée des lignes de Tram
const markersTramCoordinates = ref([])
// Affichage des parkings
const enabledCar = ref(false)
// Affichage des stations de vélos
const enabledBike = ref(true)
// Affichage des lignes et arrêt de tram
const enabledTram = ref(false)
// Affichage des arrêts de bus
const enabledBus = ref(false)
const searchTermCar = 'car'
const searchTermMoped = 'moped'

// const searchTermMoped = 'moped'
// Route pour récuperer les informations des stations de vélos
axios.get('http://localhost/api/bike/station').then((response) => {
  markersBike.value = response.data
});
// Route pour récupérer les parkings
axios.get('http://localhost/api/car/parking').then((response) => {
  markersCar.value = response.data
})
// Route pour les récupérer les arrêts de bus
axios.get('http://localhost/api/bus/stop').then((response) => {
  console.log(response.data)
  markersBus.value = response.data
});
// Route pour récupérer les lignes de tram
axios.get('http://localhost/api/tram/coordinates').then((response) => {
  markersTramCoordinates.value = response.data
});
// Route pour récupérer les arrêts de tram
axios.get('http://localhost/api/tram/stop').then((response) => {
  markersTram.value = response.data
})

function refresh() {
  axios.get('http://localhost/api/bike/station').then((response) => {
    markersBike.value = response.data
  })
}
</script>

<style>

.map {
  width: 80%;
  height: 100%;
}
</style>
