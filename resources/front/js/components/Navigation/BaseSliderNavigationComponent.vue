<template>
  <div class="slider-navigation">
    <span
      class="slider-navigation__button prev"
      tabindex="-1"
      role="button"
      @click="$emit('prev')"
    >
      <svg-alias alias="arrow-left-svg" />
    </span>
    <span
      class="slider-navigation__button next"
      tabindex="-1"
      role="button"
      @click="$emit('next')"
    >
      <svg-alias alias="arrow-right-svg" />
    </span>
  </div>
</template>
<script>
export default {
  name: "BaseSliderNavigationComponent"
};
</script>
<style lang="scss">
@import "../../../scss/components/sliderNavigation";
</style>
