<template>
  <section class="section" :aria-label="title">
    <div class="section-top">
      <h3 class="section__title">{{ title }}</h3>
      <slot name="top" />
    </div>
    <div class="section-content">
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
     */
    title: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/sections/base-section";
</style>
