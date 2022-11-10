<template>
  <transition name="alert">
    <div v-if="isShow" class="alert" :style="cssVars">
      <div class="alert-top">
        <div class="alert-title">
          <img
            v-if="isSuccess"
            class="alert__status-icon"
            src="/icons/success-circle.svg"
            alt="success"
          />
          <img v-else class="alert__status-icon" src="/icons/error-circle.svg" alt="error" />
          <span class="alert-title__text">{{ title }}</span>
        </div>

        <BaseButton class="alert__close-btn" @click="close">
          <i class="fal fa-times" />
        </BaseButton>
      </div>
      <div class="alert-content">
        <p class="alert-content__message">{{ message }}</p>
      </div>
    </div>
  </transition>
</template>

<script lang="ts">
import { Component, Vue, Prop, Emit } from 'vue-property-decorator';
import BaseButton from '~/components/UI/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class BaseAlert extends Vue {
  @Prop({ required: false, default: 5 })
  private readonly autoRemove!: number;

  @Prop({ required: true })
  private readonly isSuccess!: boolean;

  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: true })
  private readonly message!: string;

  private isShow: boolean = true;

  private get cssVars(): object {
    return {
      '--time-remove': `${this.autoRemove}s`
    };
  }

  private mounted(): void {
    setTimeout(() => {
      this.isShow = false;
    }, this.autoRemove * 1000);
  }

  @Emit('close')
  private close(event: PointerEvent): void {
    this.isShow = false;
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/alert/base-alert';
</style>
