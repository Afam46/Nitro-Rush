<template>
  <dialog id="modal" class="modal" @click="clickOnModal">
    <div class="modal-inner">
      <p>За какую цену вы хотели бы продать свое авто?</p>
      <input type="number" class="price-input" required v-model="price">
      <div class="buttons">
        <button class="btn" @click="modalClose">Отмена</button>
        <button class="btn" @click="sell" :disabled="price < 1">Готово</button>
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
    },
    clickOnModal(event){
      if(event.target === event.currentTarget){
        modal.close();
        document.body.style.overflow = 'visible';
        document.body.className = ''
      }
    },
    sell(){
      const carId = parseInt(document.body.className)
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
.price-input{
  margin-top: 15px;
  background-color: white;
}
.buttons{
  display: flex;
  justify-content: space-between;
  width: 55%;
  margin: 0 auto;
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