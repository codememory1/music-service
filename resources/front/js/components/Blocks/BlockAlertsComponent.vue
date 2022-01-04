<template>
  <div class="alerts" aria-label="Alerts">
    <transition-group name="alert-fade" mode="out-in">
      <base-alert
        v-for="(alert, index) in alerts"
        :key="index + alert.title"
        :type="alert.type"
        :title="alert.title"
        :message="alert.message"
      />
    </transition-group>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
import BaseAlert from "../BaseAlertComponent";

export default {
  name: "BlockAlertsComponent",
  components: {
    BaseAlert
  },

  computed: {
    ...mapGetters({
      alerts: "alert/getAlerts"
    })
  }
};
</script>
<style lang="scss">
@import "../../../scss/components/blocks/alerts"
</style>
