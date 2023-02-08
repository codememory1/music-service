<template>
  <BaseButton class="blue circle-play-button" @click="$emit('click', $event)">
    <i class="fal fa-play" />
  </BaseButton>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class CirclePlayButton extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/button/circle-play-button.scss';
</style>
