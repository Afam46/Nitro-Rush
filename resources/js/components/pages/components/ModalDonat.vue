<template>
  <dialog id="modalDonat" style="height: 60%;" class="modal" @click="clickOnModal">
    <div class="modal-inner">
      <p>Для приобретения кубков напишите в тг: @Afam46</p>
      <p>1 руб. = 2 кубка</p>
      <p>Минимальная сумма пополнения: 50 руб.</p>
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