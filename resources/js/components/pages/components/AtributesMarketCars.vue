<template>
  <div class="atributes-market" style="width: 80%;">
    <div class="atribute-market">
      <div class="speed-bg-car">
        <img src="../img/speed.png" alt="">
      </div>
      <p>{{ item.speed }}</p>
    </div>
    <div class="atribute-market">
      <div class="fuel-bg-car">
        <img src="../img/fuel.png" alt="">
      </div>
      <p>{{ item.fuel_max }}</p>
    </div>
    <div class="atribute-market">
      <div class="power-bg-car">
        <img src="../img/power.png" alt="">
      </div>
      <p>{{ item.power }}</p>
    </div>
  </div>
</template>

<script>
export default{
  props:{item:Object}
}
</script>
