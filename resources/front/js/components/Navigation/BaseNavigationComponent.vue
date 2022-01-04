<template>
  <nav class="navigation">
    <img
      class="navigation__logo"
      src="/public/images/logo.png"
      :alt="$attrs.app_name"
    />
    <div class="navigation-categories">
      <slot name="categories" />
    </div>
  </nav>
</template>
<script>
export default {
  name: "BaseNavigationComponent"
};
</script>
<style lang="scss">
@import "../../../scss/components/desktopNavigation";
</style>
