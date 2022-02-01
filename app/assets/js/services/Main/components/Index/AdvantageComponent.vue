<template>
  <div class="advantage">
    <div class="advantage__icon">
      <svg-alias :alias="aliasIcon" />
    </div>
    <div class="advantage__info">
      <span class="advantage__title">{{ title }}</span>
      <p class="advantage__text">
        <slot />
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: "AdvantageComponent",
  props: {
    /**
     * Advantage title
     */
    title: {
      type: String,
      required: true
    },

    /**
     * Alias icon from Aliases.js
     */
    aliasIcon: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss">
@import "../../../../../scss/services/main/advantage";
</style>
