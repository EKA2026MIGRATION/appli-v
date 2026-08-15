<template>
  <div style="position: fixed; z-index: 999; background-color: white; height: 100%; width: 95%; top: 60px; padding: 10px; overflow: auto">
    <div id="main-match">

      <div id="main-match-header">

        <div class="flex flexBetween">
          <h2>Match</h2>
          <button @click="closeMatchStartModal" style="cursor: pointer; background-color: transparent; border: none; outline: none">
            <i class="material-icons">close</i>
          </button>
        </div>


        <div class="flex flexBetween">
            <span>{{ formatMatchDate() }}</span>
            <span>{{ formatMatchTime() }}</span>
        </div>

        <div class="chrono">
          {{ formatTime }}
        </div>

        <div style="display: flex; justify-content: center; font-size: 30px; font-weight: bold; color: darkblue ">
          <span>{{ goalTeam1 }}</span>
          <span>-</span>
          <span>{{ goalTeam2 }}</span>
        </div>

        <div class="flex flexAround">
          <button v-if="winner === null" class="button" @click="toggleChrono" style="background-color: mediumseagreen; color: white; border: none; outline: none; margin-right: 10px">
            {{ chronoActive ? 'Pause' : 'Start' }}
          </button>
          <button v-if="winner === null" class="button" @click="stopChrono" style="background-color: darkred; color: white; border: none; outline: none; margin-right: 10px">Stop</button>
          <button v-if="winner === null" class="button" @click="endMatch" style="background-color: black; color: white; border: none; outline: none; margin-right: 10px">FIN</button>

        </div>
      </div>

      <div v-if="winner !== null" class="winnerResult">
        <h3>Le match est terminé</h3>
        <h4 v-if="winner === 0">Match nul</h4>
        <h4 v-if="winner === 1 || winner === 2">Le vainqueur est : {{ winner === 1 ? matchStarted.team1 : matchStarted.team2 }}</h4>
      </div>

      <div v-if="winner === null" class="match-actions">

        <h2>Actions de jeu</h2>

        <PlayerActionModal v-if="playerActionModalOpen" :selectedAction="selectedAction" :team1="team1" :team2="team2" @handlePlayerSelection="handlePlayerSelection"></PlayerActionModal>

        <div id="showActions"></div>

        <div class="row">
          <button class="button" @click="openPlayerActionModal('goal')" style="background-color: mediumseagreen; color: white; ">BUT</button>
          <button class="button" @click="openPlayerActionModal('decisive_pass')" style="background-color: mediumseagreen; color: white;">PASSE DECISIVE</button>
        </div>

        <div class="row">
          <button class="button" @click="openPlayerActionModal('ballons_recuperes')" style="background-color: mediumturquoise; color: white; ">BALLON RECUPERE</button>
        </div>

        <div class="row">
          <button class="button" @click="openPlayerActionModal('shots_saved')" style="background-color: mediumorchid; color: white; ">ARRET GARDIEN</button>
        </div>

        <hr/>

        <div class="row">
          <button class="button" @click="openPlayerActionModal('man_of_the_match')" style="background-color: #f8bb86; color: black; ">HDM</button>
        </div>

        <div class="row">
          <button class="button" @click="openPlayerActionModal('yellow_card')" style="background-color: yellow; color: black; ">JAUNE</button>
          <button class="button" @click="openPlayerActionModal('red_card')" style="background-color: red; color: black;">ROUGE</button>
        </div>

      </div>

      <div v-if="actionsList.length > 0" style="margin-bottom: 20px">
        <h4>Faits de match</h4>
        <table class="table">
          <tbody>
          <tr v-for="action in actionsList" :key="action.id">
            <td>{{ action.moment }}</td>
            <td>{{ action.action }}</td>
            <td>{{ action.playerName }}</td>
            <td>{{ action.team}}</td>
            <td>
              <button class="delete-button" @click="removeAction(action.playerId, action.action, action.moment)">
                &#10005;
              </button>
            </td>
          </tr>
          </tbody>
        </table>

      </div>

    </div>
  </div>



</template>

<style>
  #main-match {
    font-family: "Roboto", Helvetica, Arial, sans-serif!important;
    padding: 10px;
  }
  h2 {
    font-family: "Roboto", Helvetica, Arial, sans-serif!important;
  }

  #main-match-header {
    border-radius: 20px;
    border: 4px solid darkred;
    padding: 10px
  }

  .chrono {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 40px;
    font-family: "Roboto", Helvetica, Arial, sans-serif!important;
  }

  .match-actions {
    margin-top: 20px;
  }

  .match-actions .row {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 10px;
    margin-top: 10px
  }

  .match-actions .row button {
    margin-right: 10px;
    border: none; outline: none;
    height: 80px;
    min-width: 80px;
  }

  .winnerResult {
    margin-top: 20px;
    background-color: darkblue;
    color: white;
    padding: 20px;
    margin-bottom: 20px;
  }

  .delete-button {
    float: right; background-color: red; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer
  }
</style>

<script setup>
import { ref, watch, computed } from 'vue';
import PlayerActionModal from './PlayerActionModal.vue';
import axios from "axios";

const emit = defineEmits(['closeMatchStarted']);
const datas = defineProps(['matchStarted']);
const urlApi = document.getElementById('urlApi').value;
const routeUpdateMatchResult = `${urlApi}foot-match/updateResult`;
const routeUpdateMatch = `${urlApi}foot-match/update`;
const playerActionModalOpen = ref(false);
const selectedAction = ref('');
let actionsList = ref([]);
let goalTeam1 = ref(0);
let goalTeam2 = ref(0);
let winner = ref(null);

const actionsTranslation = {
      "goal": "but",
      "decisive_pass": "passe décisive",
      "ballons_recuperes": "ballon récupéré",
      "shots_saved": "arrêt gardien",
      "yellow_card": "jaune",
      "red_card": "rouge",
      "man_of_the_match": "homme du match"
}

const trans = (key) => {
  return actionsTranslation[key];
}

let matchStarted = datas.matchStarted;

console.log(matchStarted);
const team1 = matchStarted.players_team1;
const team2 = matchStarted.players_team2;


/** player management **/
const openPlayerActionModal = (actionType) => {
  selectedAction.value = actionType;
  playerActionModalOpen.value = true;
};

const removeAction = (playerId, action, moment) => {
  // remove action from actionsList
  actionsList.value = actionsList.value.filter(action => action.playerId !== playerId);

  // remove action from foot_match_result
  try {
    const response = axios.post(routeUpdateMatchResult, {
      match_id: matchStarted.id,
      child_id: playerId,
      action: action,
      moment: moment,
    }, {
      headers: {
        'Authorization': 'Bearer ' + tokenAuth
      }
    });

    console.log(response);

  } catch (error) {
    console.error("Erreur lors de la mise à jour des résultats :", error);
  }

};

const handlePlayerSelection = async (playerId, action, team, fullname) => {
  selectedAction.value = null;
  playerActionModalOpen.value = false;

  // update foot_match_result
  try {
    const response = await axios.post(routeUpdateMatchResult, {
      match_id: matchStarted.id,
      child_id: playerId,
      action: action,
      moment: chronoTime.value,
      team: team
    }, {
      headers: {
        'Authorization': 'Bearer ' + tokenAuth
      }
    });
    
    actionsList.value.push({
      playerId: playerId,
      playerName: fullname,
      action: trans(action),
      moment: chronoTime.value,
      team: team
    });

    // if action == "gaol" update goalTeam1 or goalTeam2
    if(action == "goal") {
      if(team == 1) {
        goalTeam1.value++;
      } else {
        goalTeam2.value++;
      }
    }

  } catch (error) {
    console.error("Erreur lors de la mise à jour des résultats :", error);
  }



  console.log(playerId+' '+action+' '+chronoTime.value+' '+matchStarted.id);
};


// Chronomètre
const chronoActive = ref(false);
const chronoTime = ref(0);
let chronoInterval = null;

const toggleChrono = () => {
  chronoActive.value = !chronoActive.value;
  if (chronoActive.value) {
    startChrono();
  } else {
    pauseChrono();
  }
};

const startChrono = () => {
  if (!chronoInterval) {
    chronoInterval = setInterval(() => {
      chronoTime.value++;
    }, 1000);
  }
};

const pauseChrono = () => {
  clearInterval(chronoInterval);
  chronoInterval = null;
};

const stopChrono = () => {
  clearInterval(chronoInterval);
  chronoInterval = null;
  chronoTime.value = 0;
  chronoActive.value = false;
};

const endMatch = () => {
  chronoActive.value = false;
  clearInterval(chronoInterval);
  chronoInterval = null;
  winner.value = goalTeam1.value > goalTeam2.value ? 1 : 2;
  if( goalTeam1.value == goalTeam2.value) {
    winner.value = 0;
  }

  // save score in foot_match and winner
  try {
    const response = axios.post(routeUpdateMatch, {
      match_id: matchStarted.id,
      scoreTeam1: goalTeam1.value,
      scoreTeam2: goalTeam2.value,
      isWinner: winner.value
    }, {
      headers: {
        'Authorization': 'Bearer ' + tokenAuth
      }
    });

    console.log(response);

  } catch (error) {
    console.error("Erreur lors de la mise à jour des résultats :", error);
  }

};

const formatTime = computed(() => {
  const hours = Math.floor(chronoTime.value / 3600);
  const minutes = Math.floor((chronoTime.value % 3600) / 60);
  const seconds = chronoTime.value % 60;
  return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
});

const closeMatchStartModal = () => {
  emit('closeMatchStarted');
};

/** format time **/

const formatMatchDate = () => {
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  const date = new Date(matchStarted.day); // Convertit la chaîne en objet Date
  return date.toLocaleDateString('fr-FR', options);
};


const formatMatchTime = () => {
  if (!matchStarted.day || !matchStarted.time) return ''; // Gère les valeurs indéfinies
  const dateTimeString = `${matchStarted.day}T${matchStarted.time}`;
  const dateTime = new Date(dateTimeString);
  if (isNaN(dateTime)) return ''; // Vérifie si la date est invalide
  const options = { hour: '2-digit', minute: '2-digit' };
  return dateTime.toLocaleTimeString('fr-FR', options);
};



</script>