<template>
  <BaseButton class="share__btn button_bg--blue">
    <i class="far fa-share-alt" />
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
export default class ShareButton extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/button/share-button';
</style>
