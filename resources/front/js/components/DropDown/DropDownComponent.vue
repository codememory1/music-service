<template>
  <div class="drop-down">
    <ul class="drop-down__items">
      <slot />
    </ul>
  </div>
</template>
<script>
export default {
  name: "DropDown"
};
</script>
<style lang="scss">
@import "../../../scss/components/dropDown";
</style>
