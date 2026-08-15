<template>
  <div>

    <div class="custom-container">
      <select id="month-select" v-model="selectedMonth" class="custom-select">
        <option v-for="m in months" :key="m.value" :value="m.value">{{ m.text }}</option>
      </select>
      <select id="year-select" v-model="selectedYear" class="custom-select">
        <option v-for="y in years" :key="y">{{ y }}</option>
      </select>
    </div>

    <div class="custom-container">
      <i class="material-icons" @click="previousMonth">chevron_left</i>
      <button @click="fetchData" class="button">Chercher</button>
      <i class="material-icons" @click="nextMonth">chevron_right</i>
    </div>

    <div style="overflow: auto; height: 100vh">
      <table v-if="staffData && Object.keys(staffData).length">
        <thead style="position: sticky; z-index: 999">
        <tr>
          <th>Staff</th>
          <th v-for="(day, index) in daysInMonth" :key="day" :class="getDayClass(index)">
            {{ getDayLetter(index) }}<br>{{ day }}
          </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="staff in staffData" :key="staff.staff.staff_id">
          <td class="sticky-column">
            {{ staff.staff.firstname }} {{ staff.staff.lastname }}
            <small v-if="!isStaffIdPresent"><br/>Total: {{ formatTotalTime(getTotalPresenceTime(staff.details)) }} ({{ getPresenceDays(staff.details) }} jours)</small>
          </td>
          <td v-for="day in daysInMonth" :key="day" :class="[getCellClass(staff.details, day), getDayClass(day-1)]">
            <div v-if="getDetailForDay(staff.details, day)" class="presence-details" v-html="formatPresenceDetail(getDetailForDay(staff.details, day))">
            </div>
          </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
          <td>Total Présences</td>
          <td v-for="day in daysInMonth" :key="day">{{ getPresenceCount(day) }}</td>
        </tr>
        </tfoot>
      </table>
      <div style="display: flex; justify-content: space-between;">
        <button class="typePRESENCE editButton">PRESENCE</button>
        <button class="typeABSENCE editButton">ABSENCE</button>
        <button class="typeCATCHING editButton">RATTRAPAGE</button>
        <button class="typeBONUS editButton">BONUS</button>
        <button class="typeVACATION editButton">CONGES</button>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const currentUrl = ref('');
const isStaffIdPresent = ref(false);

onMounted(() => {
  currentUrl.value = window.location.href;
  isStaffIdPresent.value = currentUrl.value.includes('/staffId/');
});

// close left menu
let width = window.innerWidth;
if (width > 1023) {
  let menuLeft = document.getElementsByClassName("menu__left")[0];
  menuLeft.style.marginLeft = (parseInt(getComputedStyle(menuLeft).marginLeft) - 260) + 'px';

  document.querySelector(".container__menu__left").style.width = "40px";
  document.querySelector(".page__container").style.width = "calc(100% - 100px)";
  document.querySelector(".closeLeftMenu i").innerHTML = "arrow_forward";
}

const today = new Date();
const defaultMonth = (today.getMonth() + 1).toString().padStart(2, '0');
const defaultYear = today.getFullYear().toString();

// API URLs and token
const urlApi = document.getElementById('urlApi').value;
const tokenAuth = document.getElementById('tokenAuth').value;
const routePresence = `${urlApi}staff/presence/speed/`;

// Months and years options
const months = [
  { value: '01', text: 'Janvier' },
  { value: '02', text: 'Février' },
  { value: '03', text: 'Mars' },
  { value: '04', text: 'Avril' },
  { value: '05', text: 'Mai' },
  { value: '06', text: 'Juin' },
  { value: '07', text: 'Juillet' },
  { value: '08', text: 'Août' },
  { value: '09', text: 'Septembre' },
  { value: '10', text: 'Octobre' },
  { value: '11', text: 'Novembre' },
  { value: '12', text: 'Décembre' }
];

const years = [];
const currentYear = new Date().getFullYear();
for (let y = currentYear - 2; y <= currentYear + 2; y++) {
  years.push(y.toString());
}

// Days of the week in French
const daysOfWeek = ['D', 'L', 'M', 'M', 'J', 'V', 'S'];

// Props
const props = defineProps({
  date: String,
  month: String,
  year: String,
  teams: Array,
  currentStaffId: String
});

const { date, month, year, currentStaffId} = props;

const teams = JSON.parse(props.teams);

// State
const selectedMonth = ref(defaultMonth);
const selectedYear = ref(defaultYear);
const staffData = ref(null);
const daysInMonth = ref([]);

// Initialize values
onMounted(() => {
  selectedMonth.value = defaultMonth;
  selectedYear.value = defaultYear;
  updateDaysInMonth();
  fetchData();
});

const updateDaysInMonth = () => {
  const year = selectedYear.value;
  const month = selectedMonth.value;
  const days = new Date(year, month, 0).getDate();
  daysInMonth.value = Array.from({ length: days }, (_, i) => i + 1);
};

const fetchData = async () => {
  updateDaysInMonth();
  const startDate = `${selectedYear.value}-${selectedMonth.value}-01`;
  const endDate = `${selectedYear.value}-${selectedMonth.value}-${daysInMonth.value.length}`;
  let routeApi = `${routePresence}${startDate}/${endDate}`;

  if(currentStaffId != null) {
    routeApi = `${routeApi}/${currentStaffId}`;
  }
  try {
    const response = await axios.get(routeApi, {
      headers: {
        'Authorization': 'Bearer ' + tokenAuth
      }
    });

    const data = Object.values(response.data);

    // Add team names to each presence detail
    for (const staff of data) {
      for (const detail of staff.details) {

        let teamNames = [];
        let teamIds = detail.teams_id_list;

        if(teamIds != null) {
          let teamIdsArray = teamIds.split(',');
          for (let i = 0; i < teamIdsArray.length; i++) {
            let teamId = teamIdsArray[i];
            const team = teams[teamId.toString()];
            if (team != "" && team != null) {
              teamNames.push(team[0].toUpperCase())
            }
          }
        }
        detail.teams = teamNames.join(' | ');
      }
    }

    staffData.value = data;
  } catch (error) {
    console.error(error);
  }
};


const nextMonth = () => {
  if (selectedMonth.value === '12') {
    selectedMonth.value = '01';
    selectedYear.value = (parseInt(selectedYear.value) + 1).toString();
  } else {
    selectedMonth.value = (parseInt(selectedMonth.value) + 1).toString().padStart(2, '0');
  }
  fetchData();
};


const previousMonth = () => {
  if (selectedMonth.value === '01') {
    selectedMonth.value = '12';
    selectedYear.value = (parseInt(selectedYear.value) - 1).toString();
  } else {
    selectedMonth.value = (parseInt(selectedMonth.value) - 1).toString().padStart(2, '0');
  }
  fetchData();
};

const getCellClass = (details, day) => {
  const dateStr = `${selectedYear.value}-${selectedMonth.value}-${String(day).padStart(2, '0')}`;
  const detail = details.find(d => d.date === dateStr);
  return detail ? "type"+detail.type_name : '';
};

const getDetailForDay = (details, day) => {
  const dateStr = `${selectedYear.value}-${selectedMonth.value}-${String(day).padStart(2, '0')}`;
  return details.find(d => d.date === dateStr);
};

const getTotalPresenceTime = (details) => {
  return details
      .filter(d => d.type_name === 'PRESENCE' || d.type_name === 'CATCHING' || d.type_name === 'BONUS')
      .reduce((total, current) => {
        const start = new Date(`1970-01-01T${current.start}Z`);
        const end = new Date(`1970-01-01T${current.end}Z`);
        const diff = (end - start) / 1000 / 60 / 60; // Convert to hours
        return total + diff;
      }, 0);
};


const getPresenceDays = (details) => {
  return details.filter(d => d.type_name === 'PRESENCE' || d.type_name === 'CATCHING' || d.type_name === 'BONUS').length;
};


const formatTotalTime = (totalHours) => {
  const hours = Math.floor(totalHours);
  const minutes = Math.round((totalHours - hours) * 60);
  return `${hours}h ${minutes > 0 ? `(${minutes}m)` : ''}`;
};

const formatPresenceDetail = (detail) => {
  const start = detail.start.substring(0, 5);
  const end = detail.end.substring(0, 5);
  const startHour = parseInt(detail.start.split(':')[0], 10);
  const endHour = parseInt(detail.end.split(':')[0], 10);
  const duration = endHour - startHour;
  return `
            ${duration}h<br/><span style="font-size: 0.7rem">${start}<br/>${end}</span>
        `;
  //<br/><span style="font-size: 0.7rem">${detail.teams}</span> show teams in presence
};

const getDayLetter = (index) => {
  const date = new Date(selectedYear.value, selectedMonth.value - 1, index + 1);
  return daysOfWeek[date.getDay()];
};

const getDayClass = (index) => {
  const date = new Date(selectedYear.value, selectedMonth.value - 1, index + 1);
  return date.getDay() === 1 ? 'monday-border' : '';
};

const getPresenceCount = (day) => {
  let count = 0;
  for (const staffId in staffData.value) {
    const details = staffData.value[staffId].details;
    const dateStr = `${selectedYear.value}-${selectedMonth.value}-${String(day).padStart(2, '0')}`;
    if (details.some(d => d.date === dateStr && (d.type_name === 'PRESENCE' || d.type_name === 'CATCHING' || d.type_name === 'BONUS'))) {
      count++;
    }
  }
  return count;
};

</script>

<style scoped>
  .material-icons {
    height: auto; width: auto;padding: 10px; color: white; background-color: darkred; cursor : pointer;
  }

  thead tr {
    position: sticky;
    top: 0;
    background-color: white;
    z-index: 1;
  }

.custom-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  vertical-align: middle;
  width: 350px;
  margin: 0 auto;
}

.custom-select {
  width: 150px;
  padding: 5px;
  border: 1px solid #ccc;
  background-color: white;
}

.button {
  width: 150px;
  margin: 0;
  cursor: pointer;
}

.custom-button:hover {
  background-color: #0056b3;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th, td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: center;
}

.monday-border {
  border-left: 2px solid #000;
}

.presence-details {
  font-style: italic;
  font-size: 0.8em;
}

  .sticky-column {
    position: sticky;
    left: 0;
    background-color: white;
    z-index: 2;
  }
</style>
