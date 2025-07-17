<template>
  <audio :src="audioSrc" controls hidden>
    <source :src="audioSrc" type="audio/mp3">
  </audio>
  <main id="game" v-if="race && car && enemyCar">
    <div class="boards">
      <div class="board" style="position: relative;">
        <p class="board-car-name">{{ car.name }}</p>
        <p class="board-name">{{ car.user.name }}</p>
        <div class="atributes" style="position: absolute;
        bottom: 20px; left: 20px;">
          <div style="width: 60%;">
            <div class="atribute">
              <div class="speed-bg"><img src="./img/speed.png" alt=""></div>
              <div class="scale">{{ car.speed }}</div>
            </div>
            <div class="atribute">
              <div class="power-bg"><img src="./img/power.png" alt=""></div>
              <div class="scale">{{ car.power }}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="board" style="text-align: end; animation-name: leftShow;
      border-radius: 0 10px 10px 0; position: relative;">
        <p class="board-car-name">{{ enemyCar.name }}</p>
        <p class="board-name">{{ enemyCar.user.name}}</p>
        <div class="atributes" style="justify-content: end; position: absolute;
        bottom: 20px; right: 20px;">
          <div style="width: 60%;">
            <div class="atribute">
              <div class="scale" style="border-radius: 10px 0 0 10px;">
                {{ enemyCar.speed }}
              </div>
              <div class="speed-bg" style="border-radius: 0 10px 10px 0;">
                <img src="./img/speed.png" alt="" style="rotate: 180deg;">
              </div>
            </div>
            <div class="atribute">
              <div class="scale" style="border-radius: 10px 0 0 10px;">
                {{ enemyCar.power }}
              </div>
              <div class="power-bg" style="border-radius: 0 10px 10px 0;">
                <img src="./img/power.png" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <ModalRace :partName="partName" :partImg="partImg" :prize="prize" :isWin="isWin" :xp="xp"/>
    <p class="counter" hidden></p>
    <div id="road-game" :style="`background-image: url(${race.img_game});`">
      <div class="enemy">
        <div class="body-enemy">
          <div class="enemy-img-car">
            <img :src="`/storage/img/${(enemyCar.name).toLowerCase()}_mask.png`"
            style="width: 100%;" :style="enemyCar.color">
            <img :src="`/storage/img/${(enemyCar.name).toLowerCase()}.png`"
            style="position: absolute; top: 0; left: 0; width: 100%;">
          </div>
        </div>
      </div>
      <div class="player">
        <div class="body-player">
          <div class="player-img-car">
            <img :src="`/storage/img/${(car.name).toLowerCase()}_mask.png`"
            style="width: 100%;" :style="car.color">
            <img :src="`/storage/img/${(car.name).toLowerCase()}.png`"
            style="position: absolute; top: 0; left: 0; width: 100%;">
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import axios from 'axios';
import ModalRace from './components/ModalRace.vue';
import audi from './sounds/carStart.mp3';

export default{
  components:{ModalRace},
  data(){
    return{
      audioSrc: audi,
      balance: 0,
      prize: 0,
      xp: 0,
      isWin: 0,
      raceId: this.$route.query.raceId,
      carId: this.$route.query.carId,
      car: null,
      race: null,
      enemyCar: null,
      count: null,
      partName: '',
      partImg: '',
      gameObjects: [],
    }
  },
  mounted(){
    this.getCar();
    this.getRace();
    this.getEnemyCar();
    this.getObjectsImg();

    function createFine(pl){
      let fine = document.createElement('div');
      fine.classList.add('fine');
      document.querySelector(pl).appendChild(fine);
      let fineText = document.createElement('p');
      fineText.textContent = -5;
      let fineImg = document.createElement('img');
      fineImg.src = '/storage/img/speed.png';
      fine.appendChild(fineText);
      fine.appendChild(fineImg);
      setTimeout(function(){
        fine.remove();
      },600);
    }
   
    const end = getRand(20000, 25000);
    let c = 4
    setTimeout(() => {
      this.playNaAudio();
      const interval = setInterval(function(){
      c--;
      document.querySelector('.counter').textContent = c;
      document.querySelector('.counter').removeAttribute("hidden");
      if(c === 0){
        clearInterval(interval);
        document.querySelector('.counter').textContent = '';
        document.querySelector('.counter').className = '';
        document.getElementById('road-game').style.animationName = 'ride';
        document.getElementById('road-game')
        .style.animationDuration =`${end - 8000}ms`;
      }
      },1000);
    },6000);

    function getRand(min, max) {
      return Math.round(Math.random() * (max - min) + min);
    }

    let sec = 2;
    let finePlayer = 0;
    let fineEnemy = 0;

    setTimeout(() => {
      const enemy = document.querySelector('.enemy');
      const player = document.querySelector('.player');

      let speedInter = setInterval(() => {
        sec -= 0.2;
        if(this.gameObjects.length > 0){
          if(getRand(0,101) > 70){
            let i = getRand(0,this.gameObjects.length-1);

            let objectContainer = document.createElement('div');
            objectContainer.classList.add('object-game');

            let objectBody = document.createElement('div');
            objectBody.style = `width : ${this.gameObjects[i].size}%;
              z-index: ${this.gameObjects[i].z_index};
              display:flex; justify-content: center;`;

            let objectImg = document.createElement('img');
            objectImg.src = `${this.gameObjects[i].img}`;
            objectImg.style.width = `${this.gameObjects[i].img_size}%`;

            document.querySelector('#road-game').appendChild(objectContainer);
            objectContainer.appendChild(objectBody);
            objectBody.appendChild(objectImg);

            if(getRand(0,1)){
              objectContainer.style.justifyContent = 'end'
              if(this.gameObjects[i].sliding){
                setTimeout(function(){
                  player.style.rotate = `${getRand(-5,5)}deg`;
                  finePlayer += 5;
                  createFine('.player-img-car');
                },700);
                setTimeout(function(){
                  player.style.rotate = `0deg`;
                },1000);
              }
            }else{
              objectContainer.style.justifyContent = 'start'
              if(this.gameObjects[i].sliding){
                setTimeout(function(){
                  enemy.style.rotate = `${getRand(-5,5)}deg`;
                  fineEnemy += 5;
                  createFine('.enemy-img-car');
                },700);
                setTimeout(function(){
                  enemy.style.rotate = `0deg`;
                },1000);
              }
            }
            objectContainer.style.animationDuration = `${sec}s`
            objectContainer.style.animationName = 'ObjectShow'
          }
        }
        let y1 = getRand(-200,200);
        let y2 = getRand(-200,200);

        document.querySelector('.body-player')
        .style.marginBottom =`${y1}px`;

        document.querySelector('.body-enemy')
        .style.marginBottom =`${y2}px`;

        if(this.race.dirt){
          let x1 = getRand(-5,5);
          let x2 = getRand(-5,5);

          if(getRand(0,1)){
            player.style.rotate = `${x1}deg`;
            document.querySelector('.body-player')
            .style.marginBottom =`${y1-100}px`;
            finePlayer += 5;
            createFine('.player-img-car');
            setTimeout(function(){
              player.style.rotate = `0deg`;
            },1900);
          }else{
            enemy.style.rotate = `${x2}deg`;
            document.querySelector('.body-enemy')
            .style.marginBottom =`${y2-100}px`;
            fineEnemy += 5;
            createFine('.enemy-img-car');
            setTimeout(function(){
              enemy.style.rotate = `0deg`;
            },1900);
          }
        }
      },2000)
      setTimeout(function(){
        clearInterval(speedInter);
      }, end - 11000)
    },10000);

    setTimeout(() => {
      const carBonus = Math.round((Math.round(this.car.speed
      - (finePlayer*10)) + this.car.power)/6);

      const enemyCarBonus = Math.round((Math.round(this.enemyCar.speed
      - (finePlayer*10)) + this.enemyCar.power)/6);

      console.log(carBonus, enemyCarBonus, carBonus - enemyCarBonus);

      if(getRand(0,101) > 50 + (carBonus - enemyCarBonus)){
        document.querySelector('.body-enemy').style.transition = '2.9s';
        document.querySelector('.body-enemy').style.marginBottom = '800px';
        setTimeout(() => {
          modalRace.showModal();
        },2000);

        axios.post(`/api/cars/defeat/${this.car.id}`);
      }else{
        if(getRand(0,101) > 1){
          axios.get('/api/parts/rand').then(res => {
            this.partName = res.data.name;
            this.partImg = res.data.img;
            localStorage.setItem('newPart', res.data.id);
          });
        }
        document.querySelector('.body-player').style.transition = '2.9s';
        document.querySelector('.body-player').style.marginBottom = '800px';
        this.isWin = 1;
        this.xp = Math.round(((this.prize/50/(parseInt(this.car.lvl))*
        Math.round(Math.random() * 2 + 1))) * 100) / 100;

        if(this.xp === 0){
          this.xp = 0.01;
        }

        setTimeout(() => {
          modalRace.showModal();
        },2000);
        
        axios.post('/api/user/balanceEdit', {price: this.prize}).then(res => {
          document.querySelector('.balance').textContent = this.balance + this.prize;
        });

        axios.post(`/api/cars/win/${this.car.id}`, {xp: this.xp});
      }
    },end);
  },

  methods:{
    getCar(){
      axios.get(`/api/cars/showRace/${this.carId}`).then(res => {
        this.car = res.data;
        this.balance = res.data.user.balance;
      })
    },
    getRace(){
      axios.get(`/api/races/show/${this.raceId}`).then(res => {
        this.race = res.data;
        let minPrize = Math.round(this.race.prize/5);
        this.prize = Math.round(Math.random() * (this.race.prize - minPrize) + minPrize);
      });
    },
    getEnemyCar(){
      axios.get('/api/cars/rand').then(res => {
        this.enemyCar = res.data
        console.log(res.data);
      });
    },
    getObjectsImg(){
      axios.post('/api/raceObjectImg',{id: this.raceId}).then(res => {
        this.gameObjects = res.data;
      })
    },
    playNaAudio(){
      document.querySelector('audio').play();
    },
  }
}
</script>

<style>
.player-img-car, .enemy-img-car{
  position: relative;
  width: 85%;
}
.fine{
  position: absolute;
  color: red;
  bottom: -40px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 55%;
  transition: .5s;
  animation-duration: 1.2s;
  animation-name: upFine;
  animation-timing-function: linear;
  opacity: 0;
}
@keyframes upFine {
  0%{
    opacity: 1;
    bottom: -40px;
  }
  100%{
    opacity: 0;
    bottom: 40px;
  }
}
.object-game{
  width: 100%;
  display: flex;
  position: absolute;
  margin-bottom: 1100px;
  justify-content: center;
  animation-timing-function: linear;
}
.object-game-body{
  display: flex;
  justify-content: center;
  width: 100%;
}
@keyframes ObjectShow {
  0%{
    margin-bottom: 1100px;
  }
  100%{
    margin-bottom: -1100px;
  }
}
#game{
  height: 100svh;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
  margin: 0 auto;
  margin-top: -88px;
}
#road-game{
  position: absolute;
  box-shadow: inset 0 0 50px black;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  top: 20px;
  background-size: cover;
  background-repeat: repeat-x;
  animation-fill-mode: forwards;
  animation-timing-function: cubic-bezier(.44,.01,.96,1);
  overflow: hidden;
  background-position: 100% 100%;
}
@keyframes ride {
  0%{
    background-position: 100% 100%;
  }
  100%{
    background-position: 0 0;
  }
}
.player{
  z-index: 10;
  width: 40%;
  display: flex;
  justify-content: center;
  animation-name: raceStart;
  animation-duration: 5s;
  animation-timing-function: linear;
  transition: .5s;
}
.enemy{
  z-index: 10;
  width: 40%;
  display: flex;
  justify-content: center;
  animation-name: raceStart;
  animation-duration: 5s;
  animation-timing-function: linear;
  transition: .5s;
}
.player img{
  width: 100%;
}
.enemy img{
  width: 100%;
}
.body-player{
  width: 46%;
  display: flex;
  justify-content: center;
  transition: 1.8s;
  position: relative;
}
.trail{
  position: absolute;
  bottom: -40px;
  transition: opacity 1s ease;
  opacity: 0;
  width: 100%;
  background-image: url(./img/trail.png);
  background-size: cover;
  height: 50px;
  z-index: -1;
}
.body-enemy{
  width: 46%;
  display: flex;
  justify-content: center;
  transition: 1.8s;
  position: relative;
}
.counter{
  position: absolute;
  margin: 0 auto;
  font-size: 60px;
  background-color: rgb(34, 40, 52, 0.95);
  border-radius: 10px;
  padding: 10px;
  text-align: center;
  z-index: 100;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
}
.board-car-name{
  font-size: 40px;
}
.board-name{
  font-size: 26px;
}
@media screen and (max-width: 800px) {
  .counter{
    font-size: 50px;
  }
  .board-car-name{
    font-size: 32px;
  }
  .board-name{
  font-size: 22px;
}
}
.boards{
  position: relative;
  overflow: hidden;
  width: 100%;
  height: 60%;
  display: flex;
  align-items: center;
}
.board {
  position: absolute;
  right: -100%;
  animation-name: rightShow;
  animation-duration: 5s;
  animation-timing-function: linear;
  z-index: 100;
  background-color: rgb(34, 40, 52, 0.95);
  box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.5);
  width: 50%;
  height: 80%;
  padding: 10px;
  border-radius: 10px 0 0 10px;
}

@keyframes rightShow{
  0%{
    right: -100%;
  }
  25%{
    right: -50%;
  }
  50%{
    right: -50%;
  }
  75%{
    right: -50%;
  }
  100%{
    right: -100%;
  }
}
@keyframes leftShow{
  0%{
    left: -100%;
  }
  25%{
    left: -50%;
  }
  50%{
    left: -50%;
  }
  75%{
    left: -50%;
  }
  100%{
    left: -100%;
  }
}
@keyframes raceStart {
  0%{
    margin-bottom: -1000px;
  }
  100%{
    margin-bottom: 0;
  }
}
</style>