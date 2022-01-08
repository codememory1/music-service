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
  name: "BaseDropDown",
  props: {
    /**
     * Show dropdown
     */
    isActive: {
      type: Boolean,
      required: true
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/context-menus/base-drop-down";
</style>
