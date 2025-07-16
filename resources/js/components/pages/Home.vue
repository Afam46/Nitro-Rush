<template>
  <main>
    <HomeParts :car="car" @getCars="getCarsAfterEquip"/>
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
    equipCarId(id){
      axios.get(`/api/cars/show/${id}`).then(res => {
        this.car = res.data;
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