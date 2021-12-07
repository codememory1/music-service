<template>
  <div class="slider-navigation">
    <span
      class="slider-navigation__button prev"
      tabindex="0"
      role="button"
      @click="$emit('prev')"
    >
      <svg-alias alias="arrow-left-svg" />
    </span>
    <span
      class="slider-navigation__button next"
      tabindex="0"
      role="button"
      @click="$emit('next')"
    >
      <svg-alias alias="arrow-right-svg" />
    </span>
  </div>
</template>
<script>
export default {
  name: "BaseSliderNavigation"
};
</script>
<style lang="scss">
@import "../../../scss/components/sliderNavigation";
</style>
