<template>
  <BaseButton class="subscribe__btn button_bg--dark">{{ $t('button.unsubscribe') }}</BaseButton>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseButton from '~/components/UI/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class UnsubscribeButton extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/button/unsubscribe';
</style>
