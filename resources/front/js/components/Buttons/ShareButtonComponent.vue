<template>
  <base-button class="bg--blue share" @click="$emit('click')">
    <i class="fal fa-share-alt"></i>
  </base-button>
</template>
<script>
import BaseButton from "./BaseButtonComponent";

export default {
  name: "ShareButtonComponent",
  components: {
    BaseButton
  }
};
</script>
<style lang="scss" scoped>
.share {
  padding: 10px;
  width: 40px;
  height: 40px;

  i {
    font-size: 19px;
  }
}
</style>
