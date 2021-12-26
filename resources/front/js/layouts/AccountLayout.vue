<template>
  <base-layout>
    <!-- Navigation -->
    <template v-slot:navigation>
      <the-account-navigation />
    </template>

    <!-- Header -->
    <template v-slot:header>
      <the-account-header />
    </template>
  </base-layout>
</template>
<script>
import BaseLayout from "./BaseLayout";
import TheAccountNavigation from "../components/Navigation/TheAccountNavigationComponent";
import TheAccountHeader from "../components/Headers/TheAccountHeaderComponent";

export default {
  name: "AccountLayout",
  components: {
    BaseLayout,
    TheAccountNavigation,
    TheAccountHeader
  }
};
</script>
