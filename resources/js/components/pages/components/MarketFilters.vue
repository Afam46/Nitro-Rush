<template>
  <div class="filters">
    <button class="filter active-filter" :disabled="activeFilterId === 0"
    @click="doActive(); activeFilterId = 0">Тачки</button>

    <button class="filter" :disabled="activeFilterId === 1"
    @click="doActive(); activeFilterId = 1" >Моды</button>
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
  background-color: #222834;
  box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.4);
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
  background: linear-gradient(to bottom right, #37B6E9, #4B4CED);
  color: white;
  cursor: default;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
}
</style>