<template>
  <dialog id="modalRace" class="modal" @click="clickOnModal">
    <div class="modal-inner">
      <div v-if="isWin">
        <p>Вы победили!!</p>
        <p>А также выиграли {{ prize }} Кубков и получили {{ xp }} опыта</p>
      </div>
      <div v-else>
        <p>К сожалению вы проиграли</p>
        <p>Но не унывайте, у вас еще будет шанс</p>
      </div>
      <router-link :to="{name:'races'}" class="btn">Сыграть еще</router-link>
      <router-link :to="{name:'home'}" class="btn">Домой</router-link>
    </div>
  </dialog>
</template>

<script>
export default{
  props:{prize:Number,isWin:Number, xp:Number},
}
</script>

<style>
.modal{
  border: none;
  padding: 0;
  position: absolute;  
  top: 50%;  
  left: 50%;  
  transform: translate(-50%, -50%); 
}
.modal::backdrop{
  background-color: rgba(0, 0, 0, 0.3);
}
.modal-inner{
  border: 1px solid black;
  padding: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  background-color: gray;
}
.btn{
  border: none;
  background-color: orangered;
  border-radius: 10px;
  color: white;
  font-size: 20px;
  padding: 5px 10px;
  cursor: pointer;
  margin-top: 15px;
}
</style>