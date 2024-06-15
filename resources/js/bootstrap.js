import axios from 'axios';
import L from 'leaflet'
import 'vue-leaflet-markercluster/dist/style.css'

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.L = L
