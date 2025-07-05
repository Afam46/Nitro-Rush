<template>
  <div class="atributes-market" style="width: 80%;">
    <div class="atribute-market">
      <div class="speed-bg-car">
        <img src="../img/speed.png" alt="" style="width: 80%;">
      </div>
      <p>{{ Math.round(item.speed * (item.rare/2)) }}</p>
    </div>
    <div class="atribute-market">
      <div class="fuel-bg-car">
        <img src="../img/fuel.png" alt="" style="width: 45%;">
      </div>
      <p>{{ item.fuel_max }}</p>
    </div>
    <div class="atribute-market">
      <div class="power-bg-car">
        <img src="../img/power.png" alt="" style="width: 80%;">
      </div>
      <p>{{ Math.round(item.power * (item.rare/2)) }}</p>
    </div>
  </div>
</template>

<script>
export default{
  props:{item:Object}
}
</script>