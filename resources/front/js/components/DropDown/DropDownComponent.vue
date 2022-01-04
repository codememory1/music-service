<template>
  <div
    class="drop-down"
    :class="{ active: isActive }"
    :aria-expanded="isActive"
  >
    <ul class="drop-down-items" role="list">
      <slot />
    </ul>
  </div>
</template>
<script>
export default {
  name: "DropDownComponent",
  props: {
    /**
     * Show dropdown
     *
     * @type {Boolean}
     */
    isActive: {
      type: Boolean,
      required: true
    }
  }
};
</script>
<style lang="scss">
@import "../../../scss/components/dropDown";
</style>
