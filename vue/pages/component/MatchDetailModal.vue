<template>
  <div class="modal-container">
    <div class="modal-content">
      <div style="overflow-y: auto; max-height: 80vh;">

          <h5 style="font-weight: bold; font-size: 18px">
              Match {{ selectedMatch.day }} {{ selectedMatch.time}}
            <i style="float: right">{{ selectedMatch.location }}</i>
          </h5>
          <h5 class="text-center"><b>{{ selectedMatch.team1 }}</b> VS <b>{{ selectedMatch.team2 }}</b></h5>
          <p class="text-center">{{ selectedMatch.score }} {{ selectedMatch.isWinner === 1 ? ' - '+selectedMatch.team1 : (selectedMatch.isWinner === 2 ? ' - '+selectedMatch.team2 : '') }}</p>

          <h5 v-if="team1Results.length > 0">Équipe {{ selectedMatch.team1 }}</h5>
          <table v-if="team1Results.length > 0" class="table">
            <thead>
            <tr>
              <th>Nom</th>
              <th>Pos</th>
              <th>Num</th>
              <th>B</th>
              <th>PD</th>
              <th>Récup</th>
              <th>Arrêt</th>
              <th>J</th>
              <th>R</th>
              <th>HDM</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="player in team1Results" :key="player.child_id">
              <td>{{ player.child_name }}</td>
              <td>{{ player.position }}</td>
              <td>{{ player.positionNumber }}</td>
              <td>{{ player.goal }}</td>
              <td>{{ player.decisivePass }}</td>
              <td>{{ player.ballonsRecuperes }}</td>
              <td>{{ player.shotsSaved }}</td>
              <td>{{ player.yellowCard }}</td>
              <td>{{ player.redCard }}</td>
              <td>{{ player.manOfTheMatch }}</td>
            </tr>
            </tbody>
          </table>

          <!-- Tableau pour l'équipe 2 -->
          <h5 v-if="team2Results.length > 0">Équipe {{ selectedMatch.team2 }}</h5>
          <table v-if="team2Results.length > 0" class="table">
            <thead>
            <tr>
              <th>Nom</th>
              <th>Pos</th>
              <th>Num</th>
              <th>B</th>
              <th>PD</th>
              <th>Récup</th>
              <th>Arrêt</th>
              <th>J</th>
              <th>R</th>
              <th>HDM</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="player in team2Results" :key="player.child_id">
              <td>{{ player.child_name }}</td>
              <td>{{ player.position }}</td>
              <td>{{ player.positionNumber }}</td>
              <td>{{ player.goal }}</td>
              <td>{{ player.decisivePass }}</td>
              <td>{{ player.ballonsRecuperes }}</td>
              <td>{{ player.shotsSaved }}</td>
              <td>{{ player.yellowCard }}</td>
              <td>{{ player.redCard }}</td>
              <td>{{ player.manOfTheMatch }}</td>
            </tr>
            </tbody>
          </table>

        <h5>Résumé du match</h5>
        <table>
          <thead>
          <tr>
            <th>Moment</th>
            <th>Action</th>
            <th>Joueur</th>
            <th>Team</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, index) in matchActions" :key="index">
            <td>{{ item.moment }}</td>
            <td>{{ trans(item.action) }}</td>
            <td>{{ item.child_fullname }}</td>
            <td>{{ (item.team == 1) ?  selectedMatch.team1 :  selectedMatch.team2 }}</td>
          </tr>
          </tbody>
        </table>


          <button class="button" style="float: right" @click="closeModal">Fermer</button>
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
  z-index: 9999;
  overflow-y: auto;
}

.modal-content {
  width: 100%;
  max-width: 700px;
  background-color: white;
  padding: 20px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

.table {
  width: 100%;
  border-collapse: collapse;
}

.table th, .table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: center;
}

.table th {
  background-color: #f2f2f2;
  font-weight: bold;
}
</style>

<script setup>
const actionsTranslation = {
  "goal": "but",
  "decisive_pass": "passe décisive",
  "ballons_recuperes": "ballon récupéré",
  "shots_saved": "arrêt gardien",
  "yellow_card": "jaune",
  "red_card": "rouge"
}
const trans = (key) => {
  return actionsTranslation[key];
}

const { selectedMatch } = defineProps(['selectedMatch']);
const emits = defineEmits(['close']);

const closeModal = () => {
  emits('close');
};

const team1Results = selectedMatch.foot_match_results.filter(player => player.team === 1);
const team2Results = selectedMatch.foot_match_results.filter(player => player.team === 2);
const matchActions = JSON.parse(selectedMatch.description);


</script>
