<template>
  <div class="alert" :style="getStyles">
    <div class="alert-icon-wrapper">
      <img class="alert__icon" :src="getIconByStatus" :alt="alert.status" />
    </div>
    <div class="alert-content-wrapper">
      <div class="alert-content">
        <span class="alert__title">{{ alert.title }}</span>
        <p class="alert__message">{{ alert.message }}</p>
      </div>
    </div>
    <div class="alert-close-wrapper">
      <BaseButton class="alert__btn-close" @click="close">
        <i class="fal fa-times" />
      </BaseButton>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Emit, Vue } from 'vue-property-decorator';
import BaseButton from '~/components/UI/Button/BaseButton.vue';
import { getAlertModule } from '~/store';
import { AlertType } from '~/types/AlertType';

@Component({
  components: {
    BaseButton
  }
})
export default class BaseAlert extends Vue {
  @Prop({ required: true })
  private readonly alert!: AlertType;

  private get getStyles(): object {
    return {
      '--time-remove': `${this.getAutoDeleteTime}s`
    };
  }

  private get getIconByStatus(): string {
    switch (this.alert.status) {
      case 'success':
        return '/icons/success-circle.svg';
      case 'error':
        return '/icons/error-circle.svg';
      default:
        return '';
    }
  }

  private get getAutoDeleteTime(): number {
    return undefined === this.alert.autoDeleteTime
      ? this.$config.alertAutoDeleteTime
      : this.alert.autoDeleteTime;
  }

  private mounted(): void {
    setTimeout(() => {
      this.close();
    }, this.getAutoDeleteTime * 1000);
  }

  @Emit('close')
  private close(): void {
    getAlertModule(this.$store).removeAlert(this.alert);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/alert/base-alert.scss';
</style>
