<template>
  <main v-if="races">
    <article id="races" v-for="race in races" :key="race.id">
      <article class="race">
        <p style="margin-top: 10px;">{{ race.name }}</p>
        <div style="width: 100%; display: flex; justify-content:
        center; align-items: center; padding: 20px 0;">
          <img :src="race.img" alt="img" style="width: 80%; box-shadow:  0 0 20px rgba(0,0,0,.5);">
        </div>
        <div class="race-info">
          <div class="fuel-bg-race">
            <p style="margin-right: 3px;">Затрата: {{ race.price }}</p>
            <img src="./img/fuel.png">
          </div>
          <div class="lvl">
            <p>{{ race.min_lvl }} ур.</p>
          </div>
        </div>
        <div class="prize-race">
          <p>{{`Награда: ${Math.round(race.prize/5)} - ${race.prize}`}}</p>
          <div class="kybok-race">
            <img src="./img/kybok.png" alt="" style="width: 70%;">
          </div>
        </div>
        <router-link class="orange-btn" 
        :to="{path: '/preparation', query: {id: race.id}}">
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
#races{
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
}
.race{
  padding: 10px;
  width: 100%;
  margin-bottom: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
}
.race-info{
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  margin: 10px 0;
}
.fuel-bg-race{
  background: linear-gradient(to bottom right, #353F54, #222834);
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
  border: 1px solid #4B4CED;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 10px;
  margin-left: 10px;
}
@media screen and (max-width: 450px) {
  .fuel-bg-race, .prize-race{
    font-size: 16px;
  }
}
@media screen and (max-width: 330px) {
  .fuel-bg-race, .prize-race{
    font-size: 14px;
  }
}
.prize-race{
  border-radius: 10px;
  border: 1px solid #4B4CED;
  background: linear-gradient(to bottom right, #353F54, #222834);
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
  padding: 8px;
  margin: 10px 0;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 60%;
}
.kybok-race{
  display: flex;
  justify-content: center;
  align-items: center;
  margin-left: 4px;
  width: 18%;
}
.kybok-race img{
  width: 100%;
}
</style>