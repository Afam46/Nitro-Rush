<template>
  <dialog id="modalRace" class="modal" @click="clickOnModal">
  <div class="modal-inner">
      <div v-if="isWin" style="width: 100%;">
        <p class="win-race-game">Победа!</p>
        <div class="race-game-prize">
          <div class="race-game-prize-item">
            <div class="race-game-bck-item" style="padding: 10px 0;">
              <img src="../img/kybok.png" alt="">
            </div>
            <p class="race-game-prize-quan">{{ prize }}</p>
          </div>
          <div class="race-game-prize-item">
            <div class="race-game-bck-item">
              <img src="../img/xp.png" alt="">
            </div>
            <p class="race-game-prize-quan">{{ xp }}</p>
          </div>
        </div>
        <div style="width: 60%; margin: 0 auto;">
          <div v-show="partName" class="race-game-bck-part">
            <div style="width: 100%; height: 100%; margin: 16px 0;
            display: flex; justify-content: center; align-items: center;">
              <img :src="partImg" alt="" style="width: 60%">
            </div>
          </div>
          <p class="race-game-prize-quan">{{ partName }}</p>
        </div>
      </div>
      <div v-else style="text-align: center;">
        <p class="win-race-game">Вы проиграли</p>
        <p style="margin-bottom: 5px;">Но не унывайте, у вас еще будет шанс</p>
      </div>
      <router-link :to="{name:'races'}" class="btn" style="margin-bottom: 0;"
      >Сыграть еще</router-link>
      <router-link :to="{name:'home'}" class="btn" @click="goHome">Домой</router-link>
    </div>
  </dialog>
</template>

<script>
export default{
  props:{prize:Number,isWin:Number,xp:Number,partName:String,partImg:String},
  methods:{
    goHome(){
      document.querySelector('#race-footer').className = '';
      document.querySelector('#home-footer').classList.add('active');
    }
  }
}
</script>

<style>
@media screen and (min-width: 1225px) {
  #modalRace{
    width: 25%
  }
}
@media screen and (max-width: 1225px) {
  #modalRace{
    width: 35%
  }
}
@media screen and (max-width: 880px) {
  #modalRace{
    width: 50%
  }
}
@media screen and (max-width: 570px) {
  #modalRace{
    width: 70%
  }
}
@media screen and (max-width: 460px) {
  #modalRace{
    width: 90%
  }
}
@media screen and (max-width: 340px) {
  .btn{
    font-size: 16px;
  }
}
.win-race-game{
  text-align: center;
  margin-bottom: 10px;
  font-size: 20px;
}
.race-game-prize {
  display: flex;
  justify-content: space-around;
  align-items: stretch;
  width: 100%;
}
.race-game-prize-item {
  align-self: stretch;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  width: 40%;
}
.race-game-bck-item{
  background: linear-gradient(to bottom right, #353F54, #222834);
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 10px 10px 0 0;
}
.race-game-bck-item img{
  width: 60%;
}
.race-game-prize-quan{
  box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.4);
  border-radius: 0 0 10px 10px;
  align-self: stretch;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 20px;
  text-align: center;
}
.race-game-bck-part{
  background: linear-gradient(to bottom right, #353F54, #222834);
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
  margin: 0 auto;
  margin-top: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 10px 10px 0 0;
  padding: 20px 0;
}
</style>