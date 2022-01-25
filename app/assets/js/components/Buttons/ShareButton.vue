<template>
  <base-button class="bg--blue share" @click="$emit('click', $event)">
    <i class="fal fa-share-alt"></i>
  </base-button>
</template>

<script>
import BaseButton from "./BaseButton";

export default {
  name: "ShareButton",
  components: {
    BaseButton
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/buttons/share-button";
</style>
