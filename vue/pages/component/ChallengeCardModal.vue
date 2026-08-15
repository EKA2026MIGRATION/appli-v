<template>
  <div style="position: fixed; z-index: 999; height: auto; width: 370px; margin: 0 5%; top: 60px; padding: 5px; overflow: auto; ">
    <button @click="closeModal" style="cursor: pointer; float: left; background-color: black; color: white">
      <i class="material-icons">close</i>
    </button>
    <div class="card-image-container" style="text-align: center; margin: auto">
      <canvas ref="canvas" width="311" height="496"></canvas>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, watch} from 'vue';

const { challengeCard } = defineProps(['challengeCard']);
const emits = defineEmits(['close']);
const canvas = ref(null);

const insertImgInCanvas = (callback) => {
  const ctx = canvas.value.getContext('2d');
  ctx.clearRect(0, 0, canvas.value.width, canvas.value.height);
  const image = new Image();
  image.onload = () => {
    ctx.drawImage(image, 0, 0, canvas.value.width, canvas.value.height);
    if (callback) {
      callback();
    }
  };
  image.src = `/assets/image/cards/${challengeCard.card_type}.png`;
};

const drawText = (text, color, x, y, fontSize = '16px', isBold = false, textAlign ="left",  fontFamily = 'Arial') => {
  const ctx = canvas.value.getContext('2d');
  const maxWidth = canvas.value.width - 20;

  if(textAlign === "center") {
    x = canvas.value.width / 2;
  }
  ctx.font = `${isBold ? 'bold' : ''} ${fontSize} ${fontFamily}`;
  ctx.fillStyle = color;
  ctx.textAlign = textAlign;

  // wrap text
  const words = text.split(' ');
  let line = '';
  let lineHeight = parseInt(fontSize, 10) * 1.5;

  for (let n = 0; n < words.length; n++) {
    let testLine = line + words[n] + ' ';
    let metrics = ctx.measureText(testLine);
    let testWidth = metrics.width;
    if (testWidth > maxWidth && n > 0) {
      ctx.fillText(line, x, y);
      line = words[n] + ' ';
      y += lineHeight;
    } else {
      line = testLine;
    }
  }

  // write text
  ctx.fillText(text, x, y);
}

const addImageOnTop = (imageSrc, x, y, width, height) => {

  console.log(imageSrc);

  const ctx = canvas.value.getContext('2d');
  const image = new Image();
  image.onload = () => {
    ctx.drawImage(image, x, y, width, height);
  };

  image.src = "/"+imageSrc;

}

const hydrateText = (challengeCard) => {

  console.log(challengeCard);
  drawText(challengeCard.child_firstname, 'black', 30, 85, '30px',  true, 'center',);
  drawText(challengeCard.card_point+" %", 'black', 30, 160, '50px');
  addImageOnTop(challengeCard.child_photo, 150, 100, 140, 190);

  /**
  drawText(challengeCard.details.goal, 'black', 10, 50);
  drawText(challengeCard.details.decisivePass, 'black', 10, 80);
  drawText(challengeCard.details.ballRecovered, 'black', 10, 110);
  drawText(challengeCard.details.shotsSaved, 'black', 10, 140);
  drawText(challengeCard.details.manOfTheMatch, 'black', 10, 170);
  drawText(challengeCard.details.yellowCard, 'black', 10, 200);
  drawText(challengeCard.details.redCard, 'black', 10, 230);
  drawText(challengeCard.details.nbMatch, 'black', 10, 260);
  drawText(challengeCard.details.statPoint.toFixed(2), 'black', 10, 290);
  drawText(challengeCard.details.cardPointValue.toFixed(2), 'black', 10, 320);**/
}

onMounted(() => {
  insertImgInCanvas(() => hydrateText(challengeCard));
});

const closeModal = () => {
  emits('close');
};

</script>
