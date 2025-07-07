<template>
  <main id="market">
    <MarketFilters @filter="showProducts"/>
    <MarketCars v-show="show === 0"/>
    <MarketParts v-show="show === 1"/>
  </main>
</template>

<script>
import MarketCars from './components/MarketCars.vue';
import MarketFilters from './components/MarketFilters.vue';
import MarketParts from './components/MarketParts.vue';

export default{
  components:{MarketCars, MarketFilters, MarketParts},
  data(){
    return{
      show: 0
    }
  },
  methods:{
    showProducts(activeFilterId){
      if(activeFilterId == 0){
        this.show = 1;
      }else{
        this.show = 0;
      }
    }
  }
}
</script>

<style>
#market{
  flex-grow: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  width: 30%;
  margin: 0 auto;
}
</style>