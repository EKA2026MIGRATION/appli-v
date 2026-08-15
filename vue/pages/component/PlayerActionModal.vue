<template>
  <div class="">

  <!-- Contenu de la modal -->
    <div class="team-players">
      <h3>Équipe 1</h3>
      <ul style="list-style-type: none;">
        <li v-for="player in team1" :key="player.id" class="player-item team1" @click="handlePlayerSelection(player.id, 1, player.fullname)">
          {{ player.fullname }}
        </li>
      </ul>
      <h3>Équipe 2</h3>
      <ul style="list-style-type: none;">
        <li v-for="player in team2" :key="player.id" class="player-item team2" @click="handlePlayerSelection(player.id, 2, player.fullname)">
          {{ player.fullname }}
        </li>
      </ul>
    </div>
  </div>
</template>

<style>
  .player-item {
    cursor: pointer;
    height: 20px;
    border: 1px solid black;
    padding: 20px;
    line-height: 1px;
    border-radius: 100px;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 10px;
  }
  .team1 {
    background-color: lightblue;
  }
  .team2 {
    background-color: lightsteelblue;
  }
</style>

<script setup>
  import {  } from 'vue';
  const em = defineEmits(['handlePlayerSelection']);

  const datas = defineProps(['team1', 'team2', 'selectedAction']);
  const team1 = datas.team1
  const team2 = datas.team2;
  const action = datas.selectedAction;

  const handlePlayerSelection = (playerId, team, fullname) => {
    em('handlePlayerSelection', playerId, action, team, fullname);
  }


</script>
