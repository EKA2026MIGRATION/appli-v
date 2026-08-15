import { createApp } from 'vue';
import FootMatch from './pages/FootMatch.vue';

const seasonsData = document.getElementById('seasonsData').value;
const seasons = JSON.parse(seasonsData);

const app = createApp(FootMatch, {
    seasonsActives: seasons
});
app.mount('#foot-match-app' );
