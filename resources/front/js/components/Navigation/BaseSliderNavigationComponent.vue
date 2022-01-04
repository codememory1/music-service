<template>
  <div class="slider-navigation">
    <base-button class="slider-navigation__button prev" @click="$emit('prev')">
      <svg-alias alias="arrow-left-svg" />
    </base-button>
    <base-button class="slider-navigation__button next" @click="$emit('next')">
      <svg-alias alias="arrow-right-svg" />
    </base-button>
  </div>
</template>
<script>
import BaseButton from "../Buttons/BaseButtonComponent";

export default {
  name: "BaseSliderNavigationComponent",
  components: {
    BaseButton
  }
};
</script>
<style lang="scss">
@import "../../../scss/components/navigations/slider";
</style>
