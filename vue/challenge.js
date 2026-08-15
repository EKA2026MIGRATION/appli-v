import { createApp } from 'vue';
import Challengers from './pages/Challenge.vue';

const seasonsData = document.getElementById('seasonsData').value;
const seasons = JSON.parse(seasonsData);

const app = createApp(Challengers, {
    seasonsActives: seasons
});
app.mount('#challenge-app' );
