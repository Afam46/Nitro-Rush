<template>
  <div v-if="cars" style="width: 100%">
  <Modal @getCars="getCars"/>
  <article class="car" v-for="car in cars" :key="car.id">
    <button class="orange-btn" @click="modalPartsShow(car.id)">Экипировать</button>
    <p>{{ car.name }}</p>
    <img @click="changeSlide" src="../demoimg/blue_car.png" alt="" :style="`background-color:${car.color};`">
    <div class="atributes" :data-na="String(car.id)">
      <div class="atribute">
        <p>Скорость</p>
        <div class="scale">{{ Math.round(car.speed * (car.rare/2)) }}</div>
      </div>
      <div class="atribute">
        <p>Бензин</p>
        <div class="scale">{{ car.fuel }}/{{ 2 * car.rare }}</div>
      </div>
      <div class="atribute">
        <p>Мощность</p>
        <div class="scale">{{ Math.round(car.power * (car.rare/2))}}</div>
      </div>
      <div class="atribute">
        <p>Экипировка: </p>
        <p>{{ car.parts_count }}/{{ car.rare }}</p>
      </div>
      <button class="rare" :style="`background-color: var(--color${car.rare});`"
      v-if="car.rare < 5" @click="levelUp(car.id, prices[car.rare-1])">
        Повысить редкость за {{prices[car.rare-1]}} кубков
      </button>
      <button v-else class="rare" style="background-color: red;">
        Максимальная редкость
      </button>
      <button class="level">Уровень {{ parseInt(car.lvl) }}</button>
      <button v-if="car.parts_count == 0"
         class="level" :disabled="carsLenght < 2" :class="carsLenght < 2 
        ?'disabled':'orange-btn'" @click="modalShow(car.id)">
        Выставить на продажу
        <span>{{carsLenght < 2 ? '(Нужно минимум 2 тачки)' : ''}}</span>
      </button>
      <button class="disabled" v-else style="margin-top: 10px;">
        Сначала нужно снять всю экипировку
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
      document.body.style.overflow = 'hidden'
      document.body.classList.add(`${carId}`)
    },
    modalPartsShow(id){
      this.$emit('clickOnEquip', id);
    },
    levelUp(carId, price){
      if(this.balance >= price){
        axios.post('/api/cars/levelUp', {id: carId, price: price}).then(res => {
          const balanceText = document.querySelector('.balance');
          balanceText.textContent = parseInt(balanceText.textContent) - price;
          this.balance -= price;
          this.getCars();
        });
      }
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
}
.atributes{
  display: flex;
  flex-direction: column;
  width: 100%;
}
.scale{
  border: 2px solid black;
  border-radius: 10px;
  font-size: 20px;
  padding-left: 10px;
}
.level{
  background-color: orangered;
  border-radius: 10px;
  margin-top: 10px;
  border: none;
  color: white;
  padding: 10px;
  font-size: 20px;
  cursor: pointer;
}
.car img{
  width: 100%;
}
.part-bonus{
  color: green;
  font-size: 16px;
}
.rare{
  text-align: center;
  border-radius: 10px;
  margin-top: 10px;
  border: none;
  color: white;
  padding: 10px;
  font-size: 20px;
  cursor: pointer;
}
</style>