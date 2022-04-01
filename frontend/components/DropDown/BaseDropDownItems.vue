<template>
  <ul class="drop-down-items">
    <slot />
  </ul>
</template>

<script>
export default {
  name: "BaseDropDownItems"
};
</script>

<style lang="scss">
@import "../../assets/css/components/drop-down/base-drop-down-items";
</style>
