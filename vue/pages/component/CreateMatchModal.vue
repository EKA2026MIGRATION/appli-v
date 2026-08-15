<template>
  <div class="modal-container">
    <div class="modal-content" style="position: relative">
      <div style="overflow-y: auto; max-height: 80vh;">
        <button class="button" style="float: right" @click="closeModal">Fermer</button>
        <h3>{{ editMode ? 'Modifier le match' : 'Créer un nouveau match' }}</h3>

        <form @submit.prevent="editMatch()">

          <div style="display: flex; justify-content: space-between;">
            <input type="date" id="date" v-model="newMatch.date" required style="margin-right: 10px">
            <input type="time" id="heure" v-model="newMatch.time" required>
          </div>

          <div style="display: flex; justify-content: space-between;">
            <input type="text" id="lieu" v-model="newMatch.location" placeholder="Lieu" required style="margin-right: 10px">
            <select id="saison" v-model="newMatch.season_id" required>
              <option v-for="season in seasons" :key="season.id" :value="season.id">{{ season.name }}</option>
            </select>
          </div>

          <div style="display: flex; justify-content: space-between;">
            <input type="text" id="equipe1" v-model="newMatch.team1" placeholder="Nom Équipe 1" required style="margin-right: 10px">
            <input type="text" id="equipe2" v-model="newMatch.team2" placeholder="Nom Équipe 2" required>
          </div>
          <div v-if="selectedMatch" style="display: flex; justify-content: space-between;">
            <input type="number" id="scoreEquipe1" v-model="newMatch.scoreTeam1" placeholder="Score Équipe 1">
            <input type="number" id="scoreEquipe2" v-model="newMatch.scoreTeam2" placeholder="Score Équipe 2">
          </div>
          <div>
            <p>Vainqueur : {{ newMatch.isWinner === 1 ? 'Équipe 1' : newMatch.isWinner === 2 ? 'Équipe 2' : 'Pas de vainqueur' }}</p>
          </div>

          <div style="display: flex; justify-content: space-between;">
            <div style="margin-right: 10px;">
              Équipe 1
              <input type="text" id="playerTeam1" placeholder="Ajout d'un.e joueu.r.se" v-model="newPlayerTeam1" @input="searchPlayerTeam(newPlayerTeam1, 1)" autocomplete="off" style="width: 100%">
              <ul>
                <li v-for="player in playersTeam1" :key="player.id">
                  {{ player.fullname}}
                  <button class="delete-button" @click.stop="deletePlayer(player, 1)">
                    &#10005;
                  </button>
                </li>
              </ul>
              <ul  v-if="filteredPlayersTeam1.length > 0" style="position: absolute; z-index: 9999; background-color: white; box-shadow: #0a0a0a; padding: 10px; list-style: none">
                <li v-for="player in filteredPlayersTeam1" :key="player.id" @click="addPlayerTeam(player, 1)" style="cursor: pointer" >
                  {{ player.fullname }}
                </li>
              </ul>
            </div>
            <div>
              Équipe 2
              <input type="text" id="playerTeam2" placeholder="Ajout d'un.e joueu.r.se" v-model="newPlayerTeam2" @input="searchPlayerTeam(newPlayerTeam2, 2)" autocomplete="off" style="width: 100%">
              <ul>
                <li v-for="player in playersTeam2" :key="player.id">
                  {{ player.fullname}}
                  <button class="delete-button" @click.stop="deletePlayer(player, 2)">
                    &#10005;
                  </button>
                </li>
              </ul>
              <ul v-if="filteredPlayersTeam2.length > 0" style="position: absolute; z-index: 9999; background-color: white; box-shadow: #0a0a0a; padding: 10px; list-style: none">
                <li v-for="player in filteredPlayersTeam2" :key="player.id" @click="addPlayerTeam(player, 2)" style="cursor: pointer" >
                  {{ player.fullname }}
                </li>
              </ul>
            </div>
          </div>
          <div style="display: flex; justify-content: space-between">
            <button type="submit" class="button">{{ editMode ? "Modifier" : "Créer" }}</button>
            <button v-if="selectedMatch.score !== null" class="button" @click="reinitMatch(selectedMatch.id)">Ré-initialiser</button>
            <button class="button" @click="deleteMatch(selectedMatch.id)">Supprimer</button>
          </div>


        </form>

      </div>
    </div>
  </div>
</template>

<style scoped>
.modal-container {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 999;
  overflow-y: auto;
}

.modal-content {
  width: 100%;
  max-width: 700px;
  background-color: white;
  padding: 20px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

.delete-button {
  float: right; background-color: red; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer
}
</style>

<script setup>

import { ref, watch } from 'vue';
import axios from "axios";
const emits = defineEmits(['close', 'create', 'edit']);
const datas = defineProps(['seasonsActives', 'selectedMatch', 'seasons', 'editMode']);
const editMode = datas.editMode;
const seasonsActives = datas.seasonsActives;
const seasons = datas.seasons;
const selectedMatch = datas.selectedMatch;
const urlApi = document.getElementById('urlApi').value;
const tokenAuth = document.getElementById('tokenAuth').value;
const routeCreateMatch = `${urlApi}foot-match/create`;
const routeUpdateMatch = `${urlApi}foot-match/update`;

const currentDate = new Date();
const currentYear = currentDate.getFullYear();
const currentMonth = String(currentDate.getMonth() + 1).padStart(2, '0');
const currentDay = String(currentDate.getDate()).padStart(2, '0');
const defaultDate = `${currentYear}-${currentMonth}-${currentDay}`;
const defaultTime = ref(new Date().toLocaleTimeString('fr-Fr', { hour: '2-digit', minute: '2-digit' }));

let newPlayerTeam1 = ref('');
let filteredPlayersTeam1 = ref([]);
let playersTeam1 = ref([]);

let newPlayerTeam2 = ref('');
let filteredPlayersTeam2 = ref([]);
let playersTeam2 = ref([]);

let playersRemove = [];

let newMatch = ref({
  date: '',
  time: '',
  team1: '',
  team2: '',
  location: '',
  season_id: '',
});

if(selectedMatch) {
  newMatch.value = {
    id: selectedMatch.id,
    date: selectedMatch.day,
    time: selectedMatch.time,
    team1: selectedMatch.team1,
    team2: selectedMatch.team2,
    location: selectedMatch.location,
    season_id: selectedMatch.season_id,
    scoreTeam1: selectedMatch.scoreTeam1,
    scoreTeam2: selectedMatch.scoreTeam2,
    isWinner: selectedMatch.isWinner
  };
  playersTeam1.value = selectedMatch.players_team1;
  playersTeam2.value = selectedMatch.players_team2;
} else {
  newMatch.value = {
    date: defaultDate,
    time: defaultTime,
    team1: '',
    team2: '',
    location: 'Club V-Stadium',
    season_id: seasonsActives[0].id,
  };
  playersTeam1.value = [];
  playersTeam2.value = [];
}

const editMatch = async () => {
  try {
    const response = await axios.post(routeCreateMatch, {
      newMatch: newMatch.value,
      playersTeam1: playersTeam1.value,
      playersTeam2: playersTeam2.value,
      playersRemove: playersRemove
    }, {
      headers: {
        'Authorization': 'Bearer ' + tokenAuth
      }
    });
    newMatch.value = response.data;
    closeModal();
  } catch (error) {
    console.error("Erreur lors de la création du match :", error);
  }
}

const searchPlayerTeam = (search, team_number) => {

  if (search.length > 2) {

    const regex = /'/gi;
    search = search.replace(regex, '27');

    let url = `child/fastsearch/${search}`;

    $.ajax({
      type: "POST",
      url: urlRequest,
      data: {
        url,
        type: "GET"
      },
      dataType: "json",
      beforeSend() {
      },
      success(json) {
        if(team_number === 1) {
          filteredPlayersTeam1.value = json;
        } else {
          filteredPlayersTeam2.value = json;

        }
      }
    });
  }
};

const addPlayerTeam = (player, team_number) => {

  if(team_number === 1) {
    filteredPlayersTeam1.value = [];

    // test if olayersTeam1 exists
    if(playersTeam1.value === undefined) {
      playersTeam1.value = [];
    }

    playersTeam1.value.push(player);
  } else {
    filteredPlayersTeam2.value = [];
    if(playersTeam2.value === undefined) {
      playersTeam2.value = [];
    }
    playersTeam2.value.push(player);
  }
};

const deletePlayer = (player, team_number) => {
  if(team_number === 1) {
    playersTeam1.value = playersTeam1.value.filter(p => p.id !== player.id);
  } else {
    playersTeam2.value = playersTeam2.value.filter(p => p.id !== player.id);
  }
  playersRemove.push(player);
};



const calculateWinner = () => {
  const scoreTeam1 = parseInt(newMatch.value.scoreTeam1);
  const scoreTeam2 = parseInt(newMatch.value.scoreTeam2);

  if (scoreTeam1 > scoreTeam2) {
    newMatch.value.isWinner = 1;
  } else if (scoreTeam1 < scoreTeam2) {
    newMatch.value.isWinner = 2;
  } else {
    newMatch.value.isWinner = 0;
  }
};

const reinitMatch = (match_id) => {
  // afficher une alerte de confirmation avant d'envoyer la requête sur l'API
  if (confirm("Êtes-vous sûr de vouloir ré-initialiser ce match ?")) {

    console.log(match_id);

    try {
      const response = axios.post(routeUpdateMatch, {
        match_id: match_id,
        reinit: 1,
      }, {
        headers: {
          'Authorization': 'Bearer ' + tokenAuth
        }
      });

      closeModal();

    } catch (error) {
      console.error("Erreur lors de la mise à jour des résultats :", error);
    }
  }
};

const deleteMatch = (match_id) => {
  if(confirm("Êtes-vous sûr de vouloir supprimer ce match ?")) {
    try {
      const response = axios.post(routeUpdateMatch, {
        match_id: match_id,
        delete: 1,
      }, {
        headers: {
          'Authorization': 'Bearer ' + tokenAuth
        }
      });

      closeModal();

    } catch (error) {
      console.error("Erreur lors de la mise à jour des résultats :", error);
    }
  }
}


// Appelle cette méthode chaque fois que les scores sont mis à jour
watch([
    () => newMatch.value.scoreTeam1,
    () => newMatch.value.scoreTeam2
    ],
    calculateWinner
);





const closeModal = () => {
  emits('close', newMatch.value);
};


</script>
