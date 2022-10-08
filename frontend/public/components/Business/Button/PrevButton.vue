<template>
  <BaseButton class="prev-next__btn button_bg--dark">
    <i class="fas fa-chevron-left"></i>
  </BaseButton>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseButton from '~/components/UI/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class PrevButton extends Vue {}
</script>

<style lang="scss">
@import '~/assets/scss/business/button/prev-next-button';
</style>
