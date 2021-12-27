<template>
  <section class="account-section">
    <div class="account-section__title-wrapper">
      <svg-alias v-if="null !== iconAlias" :alias="iconAlias" />
      <h3 class="account-section__title">{{ title }}</h3>
    </div>

    <slot />
  </section>
</template>
<script>
export default {
  props: {
    /**
     * @type {String}
     */
    title: {
      type: String,
      required: true
    },

    /**
     * @type {String}
     */
    iconAlias: {
      type: String,
      default: null,
      required: false
    }
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/variables";

.account-section {
  margin-bottom: 50px;

  :last-of-type {
    margin-bottom: 0;
  }

  &__title {
    font-size: 18px;
    font-weight: 500;
    color: $section-color;
    margin-left: 15px;

    &-wrapper {
      display: flex;
      align-items: center;
      padding-bottom: 40px;
    }
  }
}
</style>
