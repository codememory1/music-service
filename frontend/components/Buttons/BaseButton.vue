<template>
  <button class="button">
    <slot />
  </button>
</template>

<script>
export default {
  name: "BaseButton"
};
</script>
<style lang="sass">
@import "../../assets/css/components/buttons/base-button"
</style>
