<template>
  <div >
    <button class="button" style="float: right" @click="openCreateMatchModal">Créer un match</button>

    <select id="seasonSelector" v-model="selectedSeason" @change="filterMatches">
      <option v-for="season in seasons" :key="season.id" :value="season.id">{{ season.name }}</option>
    </select>

    <div style="width: auto; overflow: auto">
      <table>
        <thead>
          <tr>
            <th/>
            <th>Date du Match</th>
            <th>Heure</th>
            <th>Lieu</th>
            <th>Équipe 1</th>
            <th>Équipe 2</th>
            <th>Vainqueur</th>
            <th>Score</th>
            <th>Nom de la Saison</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="match in filteredMatches" :key="match.id" >
            <td>
              <button @click="editMatch(match)">
                <i class="material-icons" style="cursor: pointer; color: darkcyan">edit</i>
              </button>
              <button v-if="match.score === null && match.players_team1 && match.players_team2" @click="startMatch(match)">
                <i class="material-icons" style="cursor: pointer; color: mediumseagreen">play_arrow</i>
              </button>
              <button v-if="match.score !== null" @click="openModal(match)">
                <i class="material-icons" style="cursor: pointer; color: darkcyan">visibility</i>
              </button>

            </td>
            <td style="cursor: pointer">{{ match.day }}</td>
            <td style="cursor: pointer">{{ match.time }}</td>
            <td style="cursor: pointer">{{ match.location }}</td>
            <td style="cursor: pointer">{{ match.team1 }}</td>
            <td style="cursor: pointer">{{ match.team2 }}</td>
            <td style="cursor: pointer">{{ match.isWinner === 1 ? match.team1 : (match.isWinner === 0 ?  'Match nul' : match.team2 ) }}</td>
            <td style="cursor: pointer">{{ match.score }}</td>
            <td style="cursor: pointer">{{ match.season_name }}</td>

          </tr>
        </tbody>
      </table>
    </div>

    <MatchDetailModal  v-if="isModalOpen"  :selectedMatch="selectedMatch"  @close="closeModal"></MatchDetailModal>

    <MatchStartModal v-if="matchStartModalOpen" :matchStarted="matchStarted" @closeMatchStarted="closeMatchStartModal"></MatchStartModal>
    <CreateMatchModal v-if="isCreateMatchModalOpen" :editMode="editMode" :seasons="seasons" :seasonsActives="seasonsActives" :selectedMatch="selectedMatch" @close="closeCreateMatchModal"></CreateMatchModal>


  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import MatchDetailModal from './component/MatchDetailModal.vue';
import CreateMatchModal from './component/CreateMatchModal.vue';
import MatchStartModal from './component/MatchStartModal.vue'

const urlApi = document.getElementById('urlApi').value;
const tokenAuth = document.getElementById('tokenAuth').value;
const routeMatches = `${urlApi}foot-match/list`;
const { seasonsActives } = defineProps(['seasonsActives']);

let matches = ref([]);
let seasons = ref([]);
let selectedMatch = ref(null);
let isModalOpen = ref(false);
let isCreateMatchModalOpen = ref(false);
let matchStartModalOpen = ref(false);
let selectedSeason = ref(null);
let matchStarted = ref(null);
let editMode = false;

const fetchMatches = async () => {
  try {
    const response = await axios.get(routeMatches, {
      headers: {
        'Authorization': 'Bearer ' + tokenAuth
      }
    });
    matches.value = response.data;

    // Utiliser les saisons actives plutôt que d'extraire des matches
    // Cela permet d'afficher les nouvelles saisons même sans matches
    seasons.value = seasonsActives;

    // Sélectionne la première saison active par défaut (la plus récente)
    if (seasonsActives && seasonsActives.length > 0) {
      selectedSeason.value = seasonsActives[0].id;
    }

  } catch (error) {
    console.error("Erreur lors de la récupération des matchs:", error);
  }
}

// Filtrer les matches en fonction de la saison sélectionnée
let filteredMatches = ref([]);
const filterMatches = () => {
  filteredMatches.value = matches.value.filter(match => match.season_id === selectedSeason.value);
}

const openModal = (match) => {
  selectedMatch.value = match;
  isModalOpen.value = true;
}

const closeModal = () => {
  selectedMatch.value = null;
  isModalOpen.value = false;
}

const openCreateMatchModal = () => {
  selectedMatch.value = {score: null, players_team1: [], players_team2: []};
  isCreateMatchModalOpen.value = true;
  editMode = false;
};

const closeCreateMatchModal = (newMatchCreated, type = "add") => {
  isCreateMatchModalOpen.value = false;
  selectedMatch.value = false;

  if (newMatchCreated && newMatchCreated.season_id === selectedSeason.value) {
    const matchIndex = matches.value.findIndex(match => match.id === newMatchCreated.id);

    if (type === "add") {
      if (matchIndex !== -1) {
        matches.value[matchIndex] = newMatchCreated;
      } else {
        matches.value.push(newMatchCreated);
      }
    } else if (type === "delete" && matchIndex !== -1) {
      matches.value.splice(matchIndex, 1);
    }
    filterMatches();
  }
};

const editMatch = (match) => {matches
  selectedMatch.value = match;
  editMode = true;
  isCreateMatchModalOpen.value = true;
};

const startMatch = (match) => {
  matchStarted.value = match;
  matchStartModalOpen.value = true;
}

const closeMatchStartModal = () => {
  matchStarted.value = null;
  matchStartModalOpen.value = false;
}

onMounted(() => {
  fetchMatches();
});

watch(selectedSeason, () => {
  filterMatches();
});



</script>
