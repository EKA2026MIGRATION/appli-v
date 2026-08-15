<template>
  <div class="modal-overlay" @click.self="closeModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Modifier le bonus</h3>
        <button @click="closeModal" class="close-btn">
          <i class="material-icons">close</i>
        </button>
      </div>

      <div class="modal-body">
        <p><strong>{{ childName }}</strong></p>
        <div class="form-group">
          <label for="bonusPoints">Points bonus :</label>
          <input
            type="number"
            id="bonusPoints"
            v-model.number="bonusValue"
            class="form-control"
            step="0.1"
            @keyup.enter="saveBonus"
            ref="inputField"
          />
        </div>
      </div>

      <div class="modal-footer">
        <button @click="closeModal" class="btn btn-secondary">Annuler</button>
        <button @click="saveBonus" class="btn btn-primary">Valider</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  border-radius: 8px;
  width: 400px;
  max-width: 90%;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 20px;
  border-bottom: 1px solid #ddd;
}

.modal-header h3 {
  margin: 0;
  font-size: 18px;
}

.close-btn {
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
  color: #666;
}

.close-btn:hover {
  color: #333;
}

.modal-body {
  padding: 20px;
}

.form-group {
  margin-top: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form-control {
  width: 100%;
  padding: 8px 12px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 16px;
}

.form-control:focus {
  outline: none;
  border-color: #4CAF50;
  box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  padding: 15px 20px;
  border-top: 1px solid #ddd;
}

.btn {
  padding: 8px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.2s;
}

.btn-secondary {
  background-color: #6c757d;
  color: white;
}

.btn-secondary:hover {
  background-color: #5a6268;
}

.btn-primary {
  background-color: #4CAF50;
  color: white;
}

.btn-primary:hover {
  background-color: #45a049;
}
</style>

<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
  childId: Number,
  childName: String,
  currentBonus: Number
});

const emits = defineEmits(['close', 'save']);

const bonusValue = ref(props.currentBonus || 0);
const inputField = ref(null);

onMounted(() => {
  // Focus sur le champ input à l'ouverture de la modal
  inputField.value?.focus();
});

const closeModal = () => {
  emits('close');
};

const saveBonus = () => {
  emits('save', bonusValue.value);
};
</script>
