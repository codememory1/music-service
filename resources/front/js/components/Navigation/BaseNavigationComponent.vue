<template>
  <div class="navigation">
    <div class="navigation__logo">
      <img src="/public/images/logo.png" alt="logo" />
    </div>
    <div class="navigation__categories">
      <slot name="categories" />
    </div>
  </div>
</template>
<script>
export default {
  name: "BaseNavigation"
};
</script>
<style lang="scss">
@import "../../../scss/components/desktopNavigation";
</style>
