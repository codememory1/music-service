<template>
  <nav class="navigation" aria-label="Home navigation">
    <!-- Items START -->
    <ul class="navigation-items" role="menubar">
      <li class="navigation__item" role="presentation">
        <a href="#" role="menuitem">Premium</a>
      </li>
      <li class="navigation__item" role="presentation">
        <a href="#" role="menuitem">Help</a>
      </li>
      <li class="navigation__item" role="presentation">
        <a href="#" role="menuitem">Download</a>
      </li>

      <slot />
    </ul>
    <!-- Items END -->
  </nav>
</template>

<script>
export default {
  name: "TheHomeNavigation"
};
</script>

<style lang="scss" scoped>
@import "../../../scss/components/navigations/home-navigation";
</style>
