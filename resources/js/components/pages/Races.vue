<template>
  <main id="race" v-if="races">
    <article id="races" v-for="race in races" :key="race.id">
      <article class="race">
        <img src="#" alt="img">
        <p>{{ race.name }}</p>
        <p>Минимальный уровень авто: {{ race.min_lvl }}</p>
        <p>{{ race.price }}л</p>
        <p>{{`Награда: ${Math.round(race.prize/5)} - ${race.prize} кубков`}}</p>
        <router-link class="orange-btn" :to="{name: 'prep',params: {id:race.id}}">
          Начать</router-link>
      </article>
    </article>
  </main>
</template>

<script>
export default{
  data(){
    return{
      races: null
    }
  },
  mounted(){
    this.getRaces();
  },
  methods:{
    getRaces(){
      axios.get('/api/races').then(res => {
        this.races = res.data;
      })
    }
  }
}
</script>

<style>
#race{
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}
#races{
  display: flex;
  justify-content: center;
  align-items: center;
  width: 20%;
}
.race{
  padding: 10px;
  width: 90%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  margin-top: 40px;
  border-radius: 10px;
  box-shadow: 0px 0px 30px rgb(65, 65, 65);;
}
</style>