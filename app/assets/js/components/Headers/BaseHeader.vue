<template>
  <header class="header">
    <slot name="beforeProfile" />

    <!-- Right info START -->
    <div class="header-right-info">
      <base-header-bell />
      <base-header-user />
    </div>
    <!-- Right info END -->
  </header>
</template>

<script>
import BaseHeaderBell from "./BaseHeaderBell";
import BaseHeaderUser from "./BaseHeaderUser";

export default {
  name: "BaseHeader",
  components: {
    BaseHeaderBell,
    BaseHeaderUser
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/headers/base-header";
</style>
