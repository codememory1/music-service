<template>
  <div class="alert" :style="{ '--time-remove': alertService.getAutoDeleteTime(alert) + 's' }">
    <div class="alert-icon-wrapper">
      <img class="alert__icon" :src="alertService.getIconByStatus(alert)" :alt="alert.status" />
    </div>
    <div class="alert-content-wrapper">
      <div class="alert-content">
        <span class="alert__title">{{ alert.title }}</span>
        <p class="alert__message">{{ alert.message }}</p>
      </div>
    </div>
    <div class="alert-close-wrapper">
      <BaseButton class="alert__btn-close" @click="alertService.deleteAlert(alert)">
        <i class="fal fa-times" />
      </BaseButton>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import AlertInterface from '~/interfaces/ui/alert-interface';
import AlertService from '~/services/ui/alert/alert-service';

@Component({
  components: {
    BaseButton
  }
})
export default class BaseAlert extends Vue {
  @Prop({ required: true })
  private readonly alert!: AlertInterface;

  private alertService!: AlertService;

  public created(): void {
    this.alertService = new AlertService(this);
  }

  public mounted(): void {
    setTimeout(() => {
      this.alertService.deleteAlert(this.alert);
    }, this.alertService.getAutoDeleteTime(this.alert) * 1000);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/alert/base-alert.scss';
</style>
