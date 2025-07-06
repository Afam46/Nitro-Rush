<template>
  <dialog id="modal" style="height: 60%;" class="modal" @click="clickOnModal">
    <div class="modal-inner">
      <p>За какую цену вы хотели бы продать свое авто?</p>
      <input type="number" class="price-input" required v-model="price">
      <div class="buttons">
        <button class="btn" @click="modalClose">Отмена</button>
        <button v-if="price < 1" class="btn-dis">Готово</button>
        <button v-else class="btn" @click="sell">Готово</button>
      </div>
    </div>
  </dialog>
</template>

<script>
import axios from 'axios';

export default{
  data(){
    return{
      price: null,
    }
  },
  methods:{
    modalClose(){
      modal.close();
      document.body.style.overflow = 'visible';
      document.body.className = ''
      this.$emit('cdSell');
    },
    clickOnModal(event){
      if(event.target === event.currentTarget){
        modal.close();
        document.body.style.overflow = 'visible';
        document.body.className = ''
        this.$emit('cdSell');
      }
    },
    sell(){
      if(this.price > 8000000){
        this.price = 8000000;
      }
      const carId = parseInt(document.body.className)
      this.$emit('sellNa', carId);
      axios.post('/api/cars/sell',{id: carId, price: this.price});
      document.body.className = ''
      document.body.style.overflow = 'visible';
      modal.close();
      this.$emit('getCars');
    },
  }
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
  border-radius: 60px;
  background: linear-gradient(to bottom right, rgb(53, 63, 84, 0.95),
  rgb(34, 40, 52, 0.95));
  padding: 10px;
}
.modal::backdrop{
  background-color: rgba(0, 0, 0, 0.5);
}
.modal-inner{
  height: 100%;
  padding: 20px;
  border-radius: 60px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  color: white;
  border: 1px solid rgb(100, 100, 100);
  background-color: transparent;
}
.price-input{
  margin-top: 15px;
  background-color: white;
  color: black;
  padding: 5px;
  font-size: 20px;
}
.buttons{
  display: flex;
  justify-content: space-between;
  width: 55%;
  margin: 0 auto;
}
.btn{
  border: none;
  background: linear-gradient(to bottom right, #37B6E9, #4B4CED);
  border-radius: 10px;
  color: white;
  font-size: 20px;
  padding: 5px 10px;
  cursor: pointer;
  margin-top: 15px;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.4);
}
.btn-dis{
  border: none;
  background: linear-gradient(to bottom right, #353F54, #222834);
  border-radius: 10px;
  color: white;
  font-size: 20px;
  padding: 5px 10px;
  cursor: default;
  margin-top: 15px;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.4);
}
</style>