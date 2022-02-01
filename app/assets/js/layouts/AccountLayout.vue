<template>
  <base-layout>
    <!-- Navigation -->
    <template #navigation>
      <the-account-navigation />
    </template>

    <!-- Header -->
    <template #header>
      <the-account-header />
    </template>
  </base-layout>
</template>
<script>
import BaseLayout from "./BaseLayout";
import TheAccountNavigation from "../components/Navigations/TheAccountNavigation";
import TheAccountHeader from "../components/Headers/TheAccountHeader";

export default {
  name: "AccountLayout",
  components: {
    BaseLayout,
    TheAccountNavigation,
    TheAccountHeader
  }
};
</script>
