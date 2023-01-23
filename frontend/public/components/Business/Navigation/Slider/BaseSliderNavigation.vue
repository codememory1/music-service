<template>
  <div class="slider-navigation">
    <BaseButton
      class="slider-navigation__btn"
      :class="{ dark: !prevActive, blue: prevActive, disabled: !prevActive }"
      @click="$emit('prev')"
    >
      <i class="fal fa-chevron-left" />
    </BaseButton>
    <BaseButton
      class="slider-navigation__btn"
      :class="{ dark: !nextActive, blue: nextActive, disabled: !nextActive }"
      @click="$emit('next')"
    >
      <i class="fal fa-chevron-right" />
    </BaseButton>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class BaseSliderNavigation extends Vue {
  @Prop({ required: true })
  private readonly prevActive!: boolean;

  @Prop({ required: true })
  private readonly nextActive!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/navigation/slider/base-slider-navigation.scss';
</style>
