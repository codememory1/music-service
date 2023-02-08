<template>
  <div class="alert-list">
    <BaseAlert v-for="alert in alerts" :key="alert.id" :alert="alert" />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseAlert from '~/components/Business/Alert/BaseAlert.vue';
import AlertInterface from '~/interfaces/ui/alert-interface';

@Component({
  components: {
    BaseAlert
  }
})
export default class BaseAlertList extends Vue {
  private get alerts(): Array<AlertInterface> {
    return this.$store.getters['modules/alert-module/alerts'];
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/list/base-alert-list.scss';
</style>
