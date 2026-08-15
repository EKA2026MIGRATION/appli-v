import { createApp } from 'vue';
import StaffPresence from './pages/StaffPresence.vue';

const date = document.getElementById('date').value;
const month = document.getElementById('month').value;
const year = document.getElementById('year').value;
const teams = document.getElementById('teams').value;
const currentStaffId = document.getElementById('currentStaffId').value;

const app = createApp(StaffPresence, {
    date: date,
    month: month,
    year: year,
    teams: teams,
    currentStaffId: currentStaffId
});
app.mount('#staffPresence-app' );
