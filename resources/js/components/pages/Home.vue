<template>
  <main>
    <HomeParts :car="car" :parts="parts" @getCars="getCarsAfterEquip"
    @getParts="getParts" @deleteParts="parts = null"/>
    <HomeCars @clickOnEquip="equipCarId" :cars="cars" :carsLenght="carsLenght"
    @getCars="getCars" @prev="prev" @next="next"
    @getCarsAfterEquip="getCarsAfterEquip"/>
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
      parts: null,
      car: null,
      cars: null,
      carsLenght: null,
      currentSlide: 0,
    }
  },
  mounted(){
    this.getCars();
  },
  methods:{
    getParts(){
      axios.get(`/api/parts/garage/${this.car.id}`).then(res => {
        this.parts = res.data;
      });
    },
    equipCarId(id){
      axios.get(`/api/cars/show/${id}`).then(res => {
        this.car = res.data;
        this.getParts();
        modalParts.showModal();
        document.body.style.overflow = 'hidden'
      });
    },
    getCars(){
      axios.get('/api/cars/garage').then(res => {
        this.cars = res.data;
        this.carsLenght = this.cars.length;
        this.$nextTick(() => {
          this.currentSlide = 0;
          document.querySelectorAll('.car')[this.currentSlide].style.display = 'flex';
        });
      });
    },
    getCarsAfterEquip(){
      axios.get('/api/cars/garage').then(res => {
        this.cars = res.data;
        this.carsLenght = this.cars.length;
        this.$nextTick(() => {
          document.querySelectorAll('.car')[this.currentSlide].style.display = 'flex';
        });
      });
    },
    next(){
      const cars = document.querySelectorAll('.car');
      cars[this.currentSlide].style.display = 'none'
      if(this.currentSlide === cars.length-1){
        this.currentSlide = 0;
      }else{
        this.currentSlide++;
      }
      cars[this.currentSlide].style.display = 'flex';
    },
    prev(){
      const cars = document.querySelectorAll('.car');
      cars[this.currentSlide].style.display = 'none'
      if(this.currentSlide === 0){
        this.currentSlide = cars.length-1;
      }else{
        this.currentSlide--;
      }
      cars[this.currentSlide].style.display = 'flex';
    },
  }
}
</script>