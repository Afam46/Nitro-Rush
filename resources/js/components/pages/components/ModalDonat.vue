<template>
  <dialog id="modalDonat" style="height: 60%;" class="modal" @click="clickOnModal">
    <div class="modal-inner" style="text-align: center;">
      <p>Для приобретения кубков напишите в тг: @Afam46</p>
      <div style="display: flex; justify-content: center; align-items: center;
      margin: 10px auto;">
        <p>1 ₽ = 2</p>
        <img src="../img/kybok.png" alt="" style="margin-left: 3px;">
      </div>
      <div style="display: flex; justify-content: center; align-items: center;
      flex-wrap: wrap;">
        <p>Минимальная сумма пополнения:</p>
        <div style="margin-left: 5px;">50 ₽</div>
      </div>
      <button class="orange-btn" style="margin-top: 20px; width: 40%;"
      @click="modalClose">
        Понятно
      </button>
    </div>
  </dialog>
</template>

<script>
export default{
  methods:{
    modalClose(){
      modalDonat.close();
      document.body.style.overflow = 'visible';
    },
    clickOnModal(event){
      if(event.target === event.currentTarget){
        modalDonat.close();
        document.body.style.overflow = 'visible';
      }
    },
  }
}
</script>

<style>
@media screen and (max-width: 850px) {
  #modalDonat{
    width: 60%;
  }
}
@media screen and (max-width: 660px) {
  #modalDonat{
    width: 70%;
  }
  #modalDonat p{
    font-size: 14px;
  }
}
@media screen and (max-width: 580px) {
  #modalDonat{
    width: 80%;
  }
}
@media screen and (max-width: 500px) {
  #modalDonat{
    width: 90%;
  }
}
</style>