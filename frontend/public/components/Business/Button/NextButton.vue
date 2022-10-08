<template>
  <BaseButton class="prev-next__btn button_bg--blue">
    <i class="far fa-chevron-right" />
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
export default class NextButton extends Vue {}
</script>

<style lang="scss">
@import '~/assets/scss/business/button/prev-next-button';
</style>
