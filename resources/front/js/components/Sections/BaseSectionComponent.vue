<template>
  <section class="section">
    <div class="section__top">
      <span class="section__title">{{ title }}</span>
      <slot name="top" />
    </div>
    <div class="section__content">
      <slot name="content" />
    </div>
  </section>
</template>
<script>
export default {
  name: "BaseSection",
  props: {
    /**
     * Section title
     *
     * @type {String}
     */
    title: {
      type: String,
      required: true
    }
  }
};
</script>
<style lang="scss">
@import "../../../scss/components/section";
</style>
