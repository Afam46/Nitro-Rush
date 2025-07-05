<template>
  <main id="game">
    <div class="boards" v-if="car && enemyCar">
      <div class="player-board">
        <p>{{ car.name }}</p>
        <p style="font-size: 26px;">{{ userName }}</p>
      </div>
      <div class="enemy-board">
        <p>{{ enemyCar.name }}</p>
        <p style="font-size: 26px;">{{ enemyCar.user.name}}</p>
      </div>
    </div>
    <ModalRace :prize="prize" :isWin="isWin" :xp="xp"/>
    <p class="counter" hidden></p>
    <div id="road-game">
      <div class="player">
        <img src="./demoimg/blue_car_tds.png" alt="">
      </div>
      <div class="player">
        <img src="./demoimg/blue_car_tds.png" alt="">
      </div>
    </div>
  </main>
</template>

<script>
import axios from 'axios';
import ModalRace from './components/ModalRace.vue';

export default{
  components:{ModalRace},
  data(){
    return{
      userId: null,
      balance: 0,
      prize: 0,
      xp: 0,
      isWin: 0,
      raceId: this.$route.params.raceId,
      carId: this.$route.params.carId,
      car: null,
      race: null,
      enemyCar: null,
      count: null,
      userName: null,
    }
  },
  mounted(){
    this.getUser();
    this.getCar();
    this.getRace();
    this.getEnemyCar();

    let c = 4
    setTimeout(function(){
      const interval = setInterval(function(){
      c--;
      document.querySelector('.counter').textContent = c;
      document.querySelector('.counter').removeAttribute("hidden");
      if(c === 0){
        clearInterval(interval);
        document.querySelector('.counter').textContent = '';
        document.querySelector('.counter').className = '';
        document.getElementById('road-game').style.animationName = 'ride';
        document.getElementById('road-game').style.animationDuration = '.3s';
      }
      },1000);
    },6000);

    /*setTimeout(function(){
      document.getElementById('road-game').style.animationName = 'ride';
      let n = 2;
      setInterval(function(){
        n -= 0.2
        if(n <= 0.3){
          document.getElementById('road-game').style.animationDuration = '.3s';
          clearInterval();
        }
        document.getElementById('road-game').style.animationDuration = `${n}s`;
      },500)
    }, 3000);*/

    function getRand(min, max) {
      return Math.round(Math.random() * (max - min) + min);
    }
    const players = document.querySelectorAll('.player');
    const end = getRand(20000, 25000);

    setTimeout(function(){
      let speedInter = setInterval(function(){
        let x1 = getRand(1,10);
        let y1 = getRand(1,10);
        let x2 = getRand(1,10);
        let y2 = getRand(1,10);

        players[0].style.margin =`${x1}px ${y1}px`;
        players[1].style.margin = `${x2}px ${y2}px`;
      },500)
      setTimeout(function(){
        clearInterval(speedInter);
      }, end - 6000)
    },10000);

    setTimeout(() => {
      const carBonus =
      Math.round((Math.round(this.car.speed * (this.car.rare/2))
      + Math.round(this.car.power * (this.car.rare/2)))/6);

      const enemyCarBonus =
      Math.round((Math.round(this.enemyCar.speed * (this.enemyCar.rare/2))
      + Math.round(this.enemyCar.power * (this.enemyCar.rare/2)))/6);

      console.log(carBonus, enemyCarBonus, carBonus - enemyCarBonus);

      if(getRand(0,101) > 50 + (carBonus - enemyCarBonus)){
        players[0].style.transition = '2s';
        players[0].style.marginTop = '900px';
        setTimeout(() => {
          modalRace.showModal();
        },2000);

        axios.post(`/api/cars/win/${this.car.id}`, {win: this.isWin, xp: this.xp});
      }else{
        players[1].style.transition = '2s';
        players[1].style.marginTop = '900px';
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

        axios.post(`/api/cars/win/${this.car.id}`, {win: this.isWin, xp: this.xp});
      }
    },end);
  },

  methods:{
    getUser(){
      axios.get('/api/user').then(res => {
        this.balance = res.data.balance;
        this.userId = res.data.id;
        this.userName = res.data.name
      });
    },
    getCar(){
      axios.get(`/api/cars/showRace/${this.carId}`).then(res => {
        this.car = res.data;
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
  }
}
</script>

<style>
#game{
  flex-grow: 1;
  width: 30%;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 auto;
}
#road-game{
  position: absolute;
  background-image: url(demoimg/roadtds.png);
  box-shadow: inset 0 0 50px black;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 30%;
  height: 75svh;
  background-size: cover;
  background-repeat: repeat-x;
  animation-iteration-count: infinite;
  animation-timing-function: linear;
  overflow: hidden;
}
@keyframes ride {
  0%{
    background-position: 0 0;
  }
  100%{
    background-position: 100% 100%;
  }
}
.player{
  z-index: 10;
  transform: rotate(90deg);
  transition: .4s;
  width: 55%;
}
.player img{
  width: 100%;
}
.counter{
  position: absolute;
  margin: 0 auto;
  font-size: 60px;
  color: white;
  background-color: rgba(0, 0, 0, 0.37);
  padding: 10px;
  z-index: 100;
}
.boards{
  position: relative;
  overflow: hidden;
  width: 100%;
  height: 60%;
  display: flex;
  align-items: center;
}
.player-board {
  position: absolute;
  font-size: 50px;
  right: -100%;
  animation-name: rightShow;
  animation-duration: 6s;
  animation-timing-function: linear;
  z-index: 100;
  background-color: black;
  width: 45%;
  height: 80%;
  color: white;
  padding: 10px;
}
.enemy-board {
  position: absolute;
  font-size: 50px;
  left: -100%;
  animation: leftShow;
  animation-duration: 6s;
  animation-timing-function: linear;
  z-index: 100;
  background-color: black;
  width: 45%;
  height: 80%;
  color: white;
  text-align: end;
  padding: 10px;
}

@keyframes rightShow{
  0%{
    right: -100%;
  }
  25%{
    right: 0%;
  }
  50%{
    right: 0%;
  }
  75%{
    right: 0%;
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
    left: 0%;
  }
  50%{
    left: 0%;
  }
  75%{
    left: 0%;
  }
  100%{
    left: -100%;
  }
}
</style>