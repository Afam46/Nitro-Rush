<template>
  <div class="atributes-market-parts">
    <div class="atribute-market-part">
      <div class="speed-bg-car" style="width:40%;">
        <img src="../img/speed.png" alt="" style="width:80%;">
      </div>
      <p>+{{ item.speed }}</p>
    </div>
    <div class="atribute-market-part">
      <div class="fuel-bg-car" style="width:40%;">
        <img src="../img/fuel.png" alt="" style="width:55%;">
      </div>
      <p>+{{ item.fuel }}</p>
    </div>
    <div class="atribute-market-part" >
      <div class="power-bg-car" style="width:40%;">
        <img src="../img/power.png" alt="" style="width:75%;">
      </div>
      <p>+{{ item.power }}</p>
    </div>
  </div>
</template>

<script>
export default{
  props:{item:Object}
}
</script>

<style>
.atributes-market-parts{
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  margin: 10px auto;
  box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.4);
  border-radius: 10px;
}
.atribute-market-part{
  display: flex;
  width: 100%;
  align-items: center;
}
.atribute-market-part div{
  margin-right: 10px;
}
.atribute-market-part:nth-child(2){
  margin: 5px 0;
}
</style>