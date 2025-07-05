<template>
  <main id="garage">
    <HomeParts :car="car" @getCars="getCars"/>
    <HomeCars @clickOnEquip="equipCarId" :cars="cars" :carsLenght="carsLenght"
    @getCars="getCars"/>
  </main>
</template>

<script>
import axios from 'axios';
import HomeCars from './components/HomeCars.vue';
import HomeParts from './components/HomeParts.vue';

export default{
  components:{HomeCars, HomeParts},
  data(){
    return{
      car: null,
      cars: null,
      carsLenght: null,
    }
  },
  mounted(){
    this.getCars();
  },
  methods:{
    equipCarId(id){
      axios.get(`/api/cars/show/${id}`).then(res => {
        this.car = (res.data[0]);
        modalParts.showModal();
        document.body.style.overflow = 'hidden'
      });
    },
    getCars(){
      axios.get('/api/cars/garage').then(res => {
        this.cars = res.data[0];
        this.carsLenght = res.data[1];
      });
    },
  }
}
</script>

<style>
#garage{
  flex-grow: 1;
  width: 30%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  margin: 0 auto;
}
</style>