<template>
  <div id="divna" style="width: 100%" v-if="parts">
    <ModalParts @getParts="getParts"/>
    <dialog id="modalParts" class="modal" @click="clickOnModal" style="width: 50%;">
      <div class="modal-inner" v-if="car">
        <p>Выберите запчасти для тачки {{ car.name }}:</p>
        <article class="parts">
          <article class="part" v-for="part in parts" :key="part.id">
            <p style="text-align: center;">{{ part.name }}</p>
            <div class="img-block">
              <img src="../demoimg/blue_car.png" alt="">
            </div>
            <p>К скорости: +{{ part.speed }}</p>
            <p>К мощности: +{{ part.power }}</p>
            <p>Минимальный ур. тачки: {{ part.lvl }}</p>
            <div class="buttons-parts">
              <div v-if="!part.car_id">
                <button v-if="car.lvl < part.lvl"
                class="disabled" disabled>Недостаточный ур.</button>
                <button v-else-if="car.parts_count >= car.rare"
                class="disabled" disabled>Недостаточно места</button>
                <button v-else class="orange-btn" 
                @click="equip(part.id, part.lvl)">Экипировать</button>
              </div>
              <div v-else-if="part.car_id !== car.id">
                <button class="disabled" disabled>Экипировано на<br>другой машине</button>
              </div>
              <div v-else>
                <button class="orange-btn" v-if="part.car_id == car.id"
                @click="takeOff(part.id)">Снять</button>
              </div>
              <div class="orange-btn" style="margin-top: 10px;"
              v-if="!part.car_id" @click="modalShow(part.id)">Продать</div>
            </div>
          </article>
        </article>
        <button class="btn" @click="modalClose">Закрыть</button>
      </div>
    </dialog>
  </div>
</template>

<script>
import axios from 'axios';
import ModalParts from './ModalParts.vue';

export default{
  components:{ModalParts},
  props:{car:Object},
  data(){
    return{
      parts: null,
      carId: null,
    }
  },
  mounted(){
    this.getParts();
  },
  methods:{
    getParts(){
      axios.get(`/api/parts/garage`).then(res => {
        this.parts = res.data;
      });
    },
    modalClose(){
      modalParts.close();
      document.body.style.overflow = 'visible';
    },
    clickOnModal(event){
      if(event.target === event.currentTarget){
        modalParts.close();
        document.body.style.overflow = 'visible';
      }
    },
    modalShow(partId){
      modalPartSell.showModal();
      document.body.style.overflow = 'hidden';
      document.querySelector('#what').classList.add(partId);
    },
    equip(id, lvl){
      if(this.car.lvl >= lvl){
        axios.post('/api/parts/equip',{id: id, car_id: this.car.id});
        this.$emit('getCars');
        this.getParts();
        this.car.parts_count++;

        /*let atributes = document.querySelector(`[data-na='${this.car.id}']`);
        let speedAt = atributes.children[0].children[1]
        let powerAt = atributes.children[2].children[1]
        let equipCount = atributes.children[3].children[1]
        speedAt.textContent = parseInt(speedAt.textContent) + speed;
        powerAt.textContent = parseInt(powerAt.textContent) + power;
        equipCount.textContent = `${
        parseInt(equipCount.textContent.split('/')[0]) + 1}/${rare}`;*/
      }
    },
    takeOff(id){
      axios.post('/api/parts/takeOff',{id: id, car_id: this.car.id});
      this.$emit('getCars');
      this.getParts();
      this.car.parts_count--;

      /*let atributes = document.querySelector(`[data-na='${this.car.id}']`);
      let speedAt = atributes.children[0].children[1]
      let powerAt = atributes.children[2].children[1]
      let equipCount = atributes.children[3].children[1]
      speedAt.textContent = parseInt(speedAt.textContent) - speed;
      powerAt.textContent = parseInt(powerAt.textContent) - power;
      equipCount.textContent = `${
      parseInt(equipCount.textContent.split('/')[0]) - 1}/${rare}`;*/
    }
  }
}
</script>

<style scoped>
.parts{
  display: flex;
  flex-wrap: wrap;
  width: 100%;
  justify-content: center;
}
.part{
  border: solid 2px orangered;
  border-radius: 10px;
  padding: 10px;
  margin: 5px 5px;
  width: 31%;
}
.modal-inner{
  background-color: rgb(222, 222, 222);
}
.img-block{
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 10px 0;
}
.buttons-parts{
  margin-top: 10px;
}
</style>