<template>
  <transition name="fade">
    <div class="alert" :style="cssVars">
      <div class="alert-top">
        <div class="alert-title">
          <img
            v-if="alert.isSuccess"
            class="alert__status-icon"
            src="/icons/success-circle.svg"
            alt="success"
          />
          <img v-else class="alert__status-icon" src="/icons/error-circle.svg" alt="error" />
          <span class="alert-title__text">{{ alert.title }}</span>
        </div>

        <BaseButton class="alert__close-btn" @click="close">
          <i class="fal fa-times" />
        </BaseButton>
      </div>
      <div class="alert-content">
        <p class="alert-content__message">{{ alert.message }}</p>
      </div>
    </div>
  </transition>
</template>

<script lang="ts">
import { Component, Vue, Prop, Emit } from 'vue-property-decorator';
import BaseButton from '~/components/UI/Button/BaseButton.vue';
import { AlertType } from '~/types/AlertType';
import { getAlertModule } from '~/store';

@Component({
  components: {
    BaseButton
  }
})
export default class BaseAlert extends Vue {
  @Prop({ required: true })
  private readonly alert!: AlertType;

  private get cssVars(): object {
    return {
      '--time-remove': `${this.alert.autoDeleteTime}s`
    };
  }

  private mounted(): void {
    setTimeout(() => {
      this.close();
    }, this.alert.autoDeleteTime * 1000);
  }

  @Emit('close')
  private close(): void {
    getAlertModule(this.$store).removeAlert(this.alert);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/alert/base-alert';
</style>
