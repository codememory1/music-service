<template>
  <base-custom-click-button
    :class="'blue share__button'"
    @click="$emit('click')"
  >
    <i class="fal fa-share-alt"></i>
  </base-custom-click-button>
</template>
<script>
import BaseCustomClickButton from "./BaseCustomClickButtonComponent";

export default {
  name: "ShareButton",
  components: {
    BaseCustomClickButton
  }
};
</script>
<style lang="scss" scoped>
.share__button {
  padding: 10px;
  width: 40px;
  height: 40px;

  i {
    font-size: 19px;
  }
}
</style>
