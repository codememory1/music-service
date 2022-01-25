<template>
  <router-link v-if="typeof link === 'string'" :to="link">
    <slot />
  </router-link>
  <a v-else :href="link">
    <slot />
  </a>
</template>

<script>
export default {
  name: "TheHomeFooterColumnItem",
  props: {
    /**
     * String ot object for router-link
     */
    link: {
      type: [String, Object],
      required: true
    }
  }
};
</script>
