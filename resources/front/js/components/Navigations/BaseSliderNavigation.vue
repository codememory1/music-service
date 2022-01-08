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
import BaseButton from "../Buttons/BaseButton";

export default {
  name: "BaseSliderNavigation",
  components: {
    BaseButton
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/navigations/base-slider-navigation";
</style>
