<template>
  <div class="drop-down">
    <div class="drop-down-wrapper">
      <div class="drop-down-inner flex">
        <slot />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "BaseDropDown"
};
</script>

<style lang="scss">
@import "../../assets/css/components/drop-down/base-drop-down";
</style>
