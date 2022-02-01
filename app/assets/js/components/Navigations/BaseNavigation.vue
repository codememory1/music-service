<template>
  <nav class="navigation">
    <a href="/" aria-current="page">
      <img
        src="/public/images/logo.png"
        class="navigation__logo"
        :alt="$env.APP_NAME"
      />
    </a>

    <!-- Categories START -->
    <div class="navigation-categories">
      <slot name="categories" />
    </div>
    <!-- Categories END -->
  </nav>
</template>

<script>
export default {
  name: "BaseNavigation"
};
</script>

<style lang="scss">
@import "../../../scss/components/navigations/base-navigation";
</style>
