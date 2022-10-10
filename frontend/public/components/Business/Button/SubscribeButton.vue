<template>
  <BaseButton class="subscribe-unsubscribe__btn button_bg--accent">{{ $t('button.subscribe') }}</BaseButton>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseButton from '~/components/UI/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class SubscribeButton extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/button/subscribe-unsubscribe-button';
</style>
