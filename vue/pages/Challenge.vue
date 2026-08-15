<template>
  <div>
    <div>
      <select v-model="season_id" @change="onSeasonChange" class="form-control" style="width: 200px; display: inline-block; margin-right: 10px;">
        <option v-for="season in seasonsActives" :key="season.id" :value="season.id">
          {{ season.name }}
        </option>
      </select>
      <button class="btn btm-left button" @click="updateSeasonStats">
        Calcul des points de saison
      </button>
      &nbsp;
      <button class="btn btm-left button" @click="updateCarte">
        Mise à jour Carte
      </button>
    </div>
    <div style="width: auto; overflow: auto; float: none">

      <table>
        <thead>
          <tr>
            <th>Enfant</th>
            <th></th>
            <th>% Carte</th>
            <th>Carte</th>
            <th>B</th>
            <th>PD</th>
            <th>BR</th>
            <th>Arr</th>
            <th>HDM</th>
            <th>J</th>
            <th>R</th>
            <th>Nb M</th>
            <th>Bonus</th>
            <th>Points</th>
            <th>+ %</th>
          </tr>
        </thead>
        <tr v-for="result in results" :key="result.child_id">
          <td  @click.prevent="openImageInNewTab(result.child_id)" style="cursor: pointer">
              {{ result.child_name }}
          </td>
          <td  @click.prevent="openImagePublic(result.child_id)" style="cursor: pointer">
            PUBLIC
          </td>
          <td>{{ result.card_point}} %</td>
          <td>{{ result.card_type}}</td>
          <td>{{ result.details.goal}}</td>
          <td>{{ result.details.decisivePass}}</td>
          <td>{{ result.details.ballRecovered}}</td>
          <td>{{ result.details.shotsSaved}}</td>
          <td>{{ result.details.manOfTheMatch}}</td>
          <td>{{ result.details.yellowCard}}</td>
          <td>{{ result.details.redCard}}</td>
          <td>{{ result.details.nbMatch}}</td>
          <td @click="openBonusModal(result)" style="cursor: pointer; background-color: #f0f8ff;">
            {{ result.details.bonus }}
          </td>
          <td>{{ result.details.statPoint.toFixed(2)}}</td>
          <td>{{ result.details.cardPointValue.toFixed(2)}}</td>
        </tr>
      </table>
    </div>
  </div>

  <ChallengeCardModal v-if="isModalVisible" :key="modalKey" :challengeCard="selectedChallengeCard" @close="isModalVisible = false" />

  <BonusEditModal
    v-if="isBonusModalVisible"
    :childId="selectedChild?.child_id"
    :childName="selectedChild?.child_name"
    :currentBonus="selectedChild?.details?.bonus || 0"
    @close="isBonusModalVisible = false"
    @save="saveBonus"
  />

</template>

<style>
  table {
    border-collapse: collapse;
    width: 100%;
  }

  th, td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }

  th {
    background-color: #f2f2f2;
  }

  tr:nth-child(even) {
    background-color: #f2f2f2;
  }
</style>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import ChallengeCardModal from './component/ChallengeCardModal.vue';
import BonusEditModal from './component/BonusEditModal.vue';

let modalKey = ref(0);
let selectedChallengeCard = ref(null);
let isModalVisible = ref(false);
let isBonusModalVisible = ref(false);
let selectedChild = ref(null);

const { seasonsActives } = defineProps(['seasonsActives']);

const urlApi = document.getElementById('urlApi').value;
const urlHost = document.getElementById('urlHost').value;
const tokenAuth = document.getElementById('tokenAuth').value;
let results = ref(null);
let season_id = ref(seasonsActives[0].id);

const sport = 'foot';

const fetchResults = async () => {
  const routeResults = `${urlApi}challenge/results/all/${season_id.value}`;
  try {
    const response = await axios.get(routeResults, {
      headers: {
        'Authorization': 'Bearer ' + tokenAuth
      }
    });
    results.value = response.data;
  } catch (error) {
    console.error("Erreur lors de la récupération des résultats:", error);
  }
}

const onSeasonChange = () => {
  fetchResults();
}

const updateSeasonStats = async () => {
  const updateRoute = `${urlApi}challenge/calcul/stats/all/${season_id.value}/${sport}`;
  try {
    await axios.get(updateRoute, {
      headers: {
        'Authorization': 'Bearer ' + tokenAuth
      }
    });
    location.reload();
  } catch (error) {
    console.error("Erreur lors de la mise à jour des stats pour la saison:", error);
  }
}

const updateCarte = async () => {
  const route = `${urlHost}challenge/updateCarte/season/${season_id.value}`;

  try {
    const response = await axios.get(route, {
      headers: {
        'Authorization': 'Bearer ' + tokenAuth
      }
    });
    console.log(response.data);
    alert('Cartes mises à jour !');
  } catch (error) {
    console.error("Erreur lors de la mise à jour des cartes:", error);
  }
}

const openBonusModal = (result) => {
  selectedChild.value = result;
  isBonusModalVisible.value = true;
};

const saveBonus = async (bonusValue) => {
  try {
    // Mise à jour locale immédiate pour l'affichage
    if (selectedChild.value && results.value) {
      const childIndex = results.value.findIndex(r => r.child_id === selectedChild.value.child_id);
      if (childIndex !== -1) {
        results.value[childIndex].details.bonus = bonusValue;
      }
    }

    // Appel API pour sauvegarder (à implémenter côté backend)
    const updateRoute = `${urlApi}challenge/bonus/update`;
    await axios.post(updateRoute, {
      child_id: selectedChild.value.child_id,
      season_id: season_id.value,
      points: bonusValue
    }, {
      headers: {
        'Authorization': 'Bearer ' + tokenAuth
      }
    });

    // Fermer la modal
    isBonusModalVisible.value = false;
    selectedChild.value = null;

    // Optionnel : Rafraîchir les données pour avoir les points recalculés
    // await fetchResults();

  } catch (error) {
    console.error("Erreur lors de la sauvegarde du bonus:", error);
    alert('Erreur lors de la sauvegarde du bonus');
  }
};

/** refaire cette méthode avec la nouvelle photo et supprimer la modale **/
const openModalWithChallengeCard = (challengeCard) => {
  selectedChallengeCard.value = { ...challengeCard };
  modalKey.value++;
  isModalVisible.value = true;
};

const openImageInNewTab = (childId) => {
  const imageUrl = `https://appli-v.net/assets/image/cards/14/card-${childId}.png`;
  const img = new Image();
  img.src = imageUrl;
  img.style.width = '480px';
  img.style.height = 'auto';
  const newWindow = window.open("", "_blank");
  newWindow.document.write('<html><head><title>Image</title><style>body { display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }</style></head><body>' + img.outerHTML + '</body></html>');
};

const openImagePublic = (childId) => {

   let random = Math.floor(Math.random() * 10000000000);
   let random2 = Math.floor(Math.random() * 1000000000);
   let id = random+"I"+childId+"I"+random2;
   const route = `http://appli-v/public/card/challenge/${id}/`;
   window.open(route, "_blank");
}

const logChildInfo = () => {

  let show = [];
  if (results.value && results.value.length > 0) {
    results.value.forEach(result => {
      const childId = result.child_id;
      const childName = result.child_name;
      const [firstName, ...lastName] = childName.split(' ');
      const publicLink = `http://appli-v/public/card/challenge/${Math.floor(Math.random() * 10000000000)}I${childId}I${Math.floor(Math.random() * 1000000000)}/`;

      show.push(`First Name: ${firstName}, Last Name: ${lastName.join(' ')}, Child ID: ${childId}, Public Link: ${publicLink}`);
    });
    console.log(show);
  } else {
    console.log("No results available.");
  }
};



fetchResults().then(() => {
  logChildInfo();
});

</script>
