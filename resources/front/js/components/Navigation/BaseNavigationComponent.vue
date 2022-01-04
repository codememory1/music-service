<template>
  <nav class="navigation" role="navigation">
    <a href="#" aria-current="page">
      <img class="navigation__logo" src="/public/images/logo.png" alt="logo" />
    </a>
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
@import "../../../scss/components/navigations/desktop";
</style>
