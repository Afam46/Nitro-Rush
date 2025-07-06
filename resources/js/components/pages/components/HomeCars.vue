<template>
  <div v-if="cars" style="width: 100%">
  <Modal @getCars="getCars" @cdSell="cdSell = -1" @sellNa="sellNa"/>
  <article class="car" v-for="car in cars" :key="car.id">
    <button class="orange-btn" @click="modalPartsShow(car.id)"
    v-if="cdSell !== car.id">
      Экипировать
    </button>
    <button v-else class="disabled">
      Экипировать
    </button>
    <p class="car-gar-name">{{ car.name }}</p>
    <div style="width: 40%; rotate: 90deg">
      <div style="position: relative; width: 100%">
        <img :src="`/storage/img/${(car.name).toLowerCase()}_mask.png`"
        style="width: 100%;" :style="car.color">
        <img :src="`/storage/img/${(car.name).toLowerCase()}.png`"
        style="position: absolute; top: 0; left: 0; width: 100%;">
      </div>
    </div>
    <div class="atributes">
      <div style="width: 45%;">
        <div class="atribute">
          <div class="speed-bg"><img src="../img/speed.png" alt=""></div>
          <div class="scale">{{ Math.round(car.speed * (car.rare/2)) }}</div>
        </div>
        <div class="atribute">
          <div class="fuel-bg"><img src="../img/fuel.png" alt=""></div>
          <div class="scale">{{ car.fuel }}/{{ car.fuel_max }}</div>
        </div>
        <div class="atribute">
          <div class="power-bg"><img src="../img/power.png" alt=""></div>
          <div class="scale">{{ Math.round(car.power * (car.rare/2))}}</div>
        </div>
      </div>
      <div style="margin-top: 10px; width: 50%;">
        <div class="level">Уровень {{ parseInt(car.lvl) }}</div>
        <div class="atribute">
          <div class="mod-bg"><img src="../img/mod.png" alt=""></div>
          <div class="scale">{{ car.parts_count }}/{{ car.rare }}</div>
        </div>
        <button class="rare" :style="`background-color: var(--color${car.rare});`"
        v-if="car.rare < 5" @click="levelUp(car.id, prices[car.rare-1])">
          {{ rareNames[car.rare-1] }}<br>{{prices[car.rare-1]}} кубков
        </button>
        <button v-else class="rare" style="background-color: red; cursor: default;">
          Мифический<br>(макс.)
        </button>
      </div>
    </div>
    <div style="margin: 10px 0; width: 100%;">
      <button v-if="car.parts_count > 0" class="disabled" style="margin-top: 10px;">
        Сначала нужно снять всю экипировку
      </button>
      <button v-else-if="carsLenght < 2" class="disabled">
        Нужно минимум 2 тачки для продажи
      </button>
      <button v-else class="orange-btn" @click="modalShow(car.id)">
        Выставить на продажу
      </button>
    </div>
  </article>
  </div>
</template>

<script>
import axios from 'axios'
import Modal from './Modal.vue';

export default{
  components:{Modal},
  props:{cars:Object,carsLenght:Number},
  data(){
    return{
      prices: [200,500,2000,5000],
      balance: 0,
      rareNames: ['Обычный','Редкий','Эпический','Легендарный'],
      cdSell: true,
      cd: true,
    }
  },
  mounted(){
    this.getBalance();
  },
  methods:{
    getBalance(){
      axios.get('/api/user/balance').then(res => {
        this.balance = res.data;
      });
    },
    getCars(){
      this.$emit('getCars');
    },
    modalShow(carId){
      modal.showModal();
      this.cdSell = carId;
      document.body.style.overflow = 'hidden'
      document.body.classList.add(`${carId}`)
    },
    modalPartsShow(id){
      this.$emit('clickOnEquip', id);
    },
    levelUp(carId, price, rare){
      if(this.balance >= price && this.cd){
        this.cd = false;
        axios.post('/api/cars/levelUp', {id: carId, price: price}).then(res => {
          const balanceText = document.querySelector('.balance');
          balanceText.textContent = parseInt(balanceText.textContent) - price;
          this.balance -= price;
          this.getCars();
          this.cd = true;
        });
      }
    },
    sellNa(carId){
      this.cdSell = carId;
    }
  }
}
</script>

<style>
.car{
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  margin-bottom: 80px;
  width: 75%;
  margin: 40px auto;
}
.level{
  background: linear-gradient(to bottom right, #37B6E9, #4B4CED);
  height: 60px;
  border-radius: 10px;
  border: none;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 10px;
  font-size: 18px;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.4);
}
.rare{
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 10px;
  margin-top: 10px;
  border: none;
  color: white;
  padding: 10px;
  font-size: 18px;
  cursor: pointer;
  height: 60px;
  width: 100%;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.4);
}
.atributes{
  display: flex;
  justify-content: space-between;
  width: 100%;
}
.atribute{
  display: flex;
  font-size: 18px;
  align-items: stretch;
  margin-top: 10px;
  border-radius: 10px;
}
.scale{
  border-radius: 0 10px 10px 0;
  box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5);
  align-self: stretch;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 10px;
  width: 100%;
}
.power-bg{
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  width: 80%;
  background: linear-gradient(to bottom right, #353F54, #222834);
  height: 60px;
  border-radius: 10px 0 0 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 4px;
}
.power-bg img{
  width: 90%;
}
.speed-bg{
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  width: 80%;
  background: linear-gradient(to bottom right, #353F54, #222834);
  height: 60px;
  border-radius: 10px 0 0 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 4px;
}
.speed-bg img{
  width: 90%;
}
.fuel-bg{
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  width: 80%;
  background: linear-gradient(to bottom right, #353F54, #222834);
  height: 60px;
  border-radius: 10px 0 0 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 4px;
}
.fuel-bg img{
  width: 75%;
}
.mod-bg{
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  width: 80%;
  background: linear-gradient(to bottom right, #353F54, #222834);
  height: 60px;
  border-radius: 10px 0 0 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 4px;
}
.mod-bg img{
  width: 88%;
}
.car-gar-name{
  margin-top: 10px;
  font-size: 20px;
}
</style>