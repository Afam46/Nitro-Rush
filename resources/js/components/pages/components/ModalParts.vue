<template>
  <dialog id="modalPartSell" class="modal" @click="clickOnModal">
    <div class="modal-inner">
      <p id="what">За какую цену вы хотели бы продать свой товар?</p>
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
      modalPartSell.close();
      document.body.style.overflow = 'visible';
      document.querySelector('#what').className = ''
    },
    clickOnModal(event){
      if(event.target === event.currentTarget){
        modalPartSell.close();
        document.body.style.overflow = 'visible';
        document.querySelector('#what').className = ''
      }
    },
    sell(){
      const partId = parseInt(document.querySelector('#what').className)
      axios.post('/api/parts/sell',{id: partId, price: this.price});
      document.querySelector('#what').className = ''
      document.body.style.overflow = 'visible';
      modalPartSell.close();
      this.$emit('getParts');
    },
  }
}
</script>