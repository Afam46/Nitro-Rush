<template>
  <div id="divna" style="width: 100%" v-if="parts">
    <ModalParts @getParts="getParts" @cdSell="cdSell = null" 
    @sellNa="sellNa"/>
    <dialog id="modalParts" class="modal" @click="clickOnModal" style="
    box-shadow: inset 0 0 10px rgb(0, 0, 0, 0.4); min-width: 52%;">
      <div class="modal-inner" v-if="car" style="border: none;">
        <p style="font-size: 20px; margin-bottom: 10px;">
          Выберите запчасти для {{ car.name }}:
        </p>
        <button class="orange-btn" style="margin: 10px 0; width: 50%;"
        @click="takeOffAll" v-if="car.parts_count > 0">Снять все</button>
        <article class="parts">
          <article class="part" v-for="part in parts" :key="part.id"
          @click="removeStorageNewPart(part.id)">
            <p style="text-align: center;">{{ part.name }}</p>
            <div class="img-block" style="width: 100%; min-height: 130px;">
              <p style="text-align: center; background:
              linear-gradient(to bottom right, #37B6E9, #4B4CED);
              border-radius: 10px; position: absolute; width: 20%;"
              v-if="newPart === part.id">Новое</p>
              <img :src="part.img" alt="" style="width: 70%;">
            </div>
            <div class="part-info">
              <div style="width: 70%;">
                <div class="part-bonus">
                  <div class="speed-bg-part"><img src="../img/speed.png" alt=""></div>
                  <p>+{{ part.speed }}</p>
                </div>
                <div class="part-bonus">
                  <div class="power-bg-part"><img src="../img/power.png" alt=""></div>
                  <p>+{{ part.power }}</p>
                </div>
                <div class="part-bonus">
                  <div class="fuel-bg-part"><img src="../img/fuel.png" alt=""></div>
                  <p>+{{ part.fuel }}</p>
                </div>
              </div>
              <div class="part-min-lvl">
                <p>{{ part.lvl }} ур.</p>
              </div>
            </div>
            <div class="buttons-parts">
              <div v-if="!part.car_id">
                <button v-if="car.lvl < part.lvl"
                class="disabled" disabled>Недостаточный уровень</button>
                <button v-else-if="car.parts_count >= car.rare"
                class="disabled" disabled>Недостаточно места</button>
                <button v-else-if="cd && cdSell !== part.id" class="orange-btn" 
                @click="equip(part.id, part.lvl), part.car_id = car.id">Экипировать</button>
                <button v-else class="disabled">Экипировать</button>
              </div>
              <div v-else-if="part.car_id !== car.id">
                <button class="disabled" disabled>Экипировано на<br>другой машине</button>
              </div>
              <div v-else>
                <button class="orange-btn" v-if="part.car_id == car.id && cd"
                @click="takeOff(part.id), part.car_id = null">Снять</button>
              </div>
              <div class="orange-btn" style="margin-top: 10px;"
              v-if="!part.car_id && cd" @click="modalShow(part.id)">Продать</div>
            </div>
          </article>
        </article>
        <button class="btn" @click="modalClose"
        style="padding: 5px 16px;">Закрыть</button>
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
      newPart: parseInt(localStorage.getItem('newPart')),
      cd: 1,
      cdSell: null,
    }
  },
  mounted(){
    this.getParts();
  },
  methods:{
    getParts(){
      axios.get(`/api/parts/garage`).then(res => {
        this.parts = res.data;
        this.cd = 1;
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
      this.cdSell = partId;
    },
    equip(id, lvl){
      if(this.car.lvl >= lvl){
        axios.post('/api/parts/equip',{id: id, car_id: this.car.id});
        this.$emit('getCars');
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
      this.car.parts_count--;

      /*let atributes = document.querySelector(`[data-na='${this.car.id}']`);
      let speedAt = atributes.children[0].children[1]
      let powerAt = atributes.children[2].children[1]
      let equipCount = atributes.children[3].children[1]
      speedAt.textContent = parseInt(speedAt.textContent) - speed;
      powerAt.textContent = parseInt(powerAt.textContent) - power;
      equipCount.textContent = `${
      parseInt(equipCount.textContent.split('/')[0]) - 1}/${rare}`;*/
    },
    takeOffAll(){
      axios.post('/api/parts/takeOffAll',{car_id: this.car.id});
      this.$emit('getCars');
      this.car.parts_count = 0;
      this.cd = 0;
      this.getParts();
    },
    removeStorageNewPart(id){
      if(this.newPart === id){
        localStorage.removeItem('newPart');
        this.newPart = -1;
      }
    },
    sellNa(partId){
      this.cdSell = partId;
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
  border-radius: 10px;
  padding: 10px;
  margin: 5px 5px;
  width: 31%;
  box-shadow: 0 0 20px rgb(0, 0, 0, 0.4);
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
.speed-bg-part {
  width: 40%;
  background: linear-gradient(to bottom right, #353F54, #222834);
  box-shadow: 0 0 10px rgb(0, 0, 0, 0.4);
  height: 30px;
  border-radius: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 4px;
  margin: 0 10px 0 0;
  border: 1px solid #4B4CED;
}
.power-bg-part {
  width: 40%;
  background: linear-gradient(to bottom right, #353F54, #222834);
  box-shadow: 0 0 10px rgb(0, 0, 0, 0.4);
  height: 30px;
  border-radius: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 4px;
  margin: 10px 10px 10px 0;
  border: 1px solid #4B4CED;
}
.fuel-bg-part {
  width: 40%;
  background: linear-gradient(to bottom right, #353F54, #222834);
  box-shadow: 0 0 10px rgb(0, 0, 0, 0.4);
  height: 30px;
  border-radius: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 4px;
  margin: 0 10px 0 0;
  border: 1px solid #4B4CED;
}
.part-bonus{
  display: flex;
  align-items: center;
}
.part-info{
  display: flex;
  justify-content: space-between;
  border-radius: 10px;
  box-shadow: inset 0 0 10px rgb(0, 0, 0, 0.4);
  padding: 8px;
}
.part-min-lvl{
  background: linear-gradient(to bottom right, #37B6E9, #4B4CED);
  color: white;
  border-radius: 10px;
  width: 30%;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>