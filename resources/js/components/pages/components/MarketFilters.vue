<template>
  <div class="filters">
    <button class="filter active-filter" :disabled="activeFilterId === 0"
    @click="doActive(); activeFilterId = 0">Тачки</button>

    <button class="filter" :disabled="activeFilterId === 1"
    @click="doActive(); activeFilterId = 1" >Запчасти</button>
  </div>
</template>

<script>
export default{
  data(){
    return{
      activeFilterId: 0,
    }
  },
  methods:{
    doActive(){
      document.querySelectorAll('.filter')[this.activeFilterId]
      .classList.remove('active-filter');

      this.$emit('filter',this.activeFilterId);

      event.target.classList.add('active-filter');
    }
  }
}
</script>

<style>
.filters{
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: rgb(202, 202, 202);
  border-radius: 10px;
}
.filter{
  font-size: 18px;
  padding: 6px 12px;
  border-radius: 10px;
  cursor: pointer;
  transition: .2s;
}
.active-filter{
  background-color: orangered;
  color: white;
  cursor: default;
}
</style>