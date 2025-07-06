<template>
  <dialog id="modalPartSell" class="modal" @click="clickOnModal" style="height: 60%;">
    <div class="modal-inner" style="background-color: transparent;
    border: 1px solid rgb(100, 100, 100);">
      <p id="what">За какую цену вы хотели бы продать свой товар?</p>
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
      modalPartSell.close();
      document.body.style.overflow = 'visible';
      document.querySelector('#what').className = ''
      this.$emit('cdSell');
    },
    clickOnModal(event){
      if(event.target === event.currentTarget){
        modalPartSell.close();
        document.body.style.overflow = 'visible';
        document.querySelector('#what').className = ''
        this.$emit('cdSell');
      }
    },
    sell(){
      if(this.price > 8000000){
        this.price = 8000000;
      }
      const partId = parseInt(document.querySelector('#what').className)
      axios.post('/api/parts/sell',{id: partId, price: this.price});
      this.$emit('sellNa', partId);
      document.querySelector('#what').className = ''
      document.body.style.overflow = 'visible';
      modalPartSell.close();
      this.$emit('getParts');
    },
  }
}
</script>