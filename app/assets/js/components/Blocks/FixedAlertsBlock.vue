<template>
  <div class="alerts">
    <transition-group name="alert-fade">
      <base-fixed-alert
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
import BaseFixedAlert from "../Alerts/BaseFixedAlert";

export default {
  name: "AlertsBlock",
  components: {
    BaseFixedAlert
  },

  computed: {
    ...mapGetters({
      alerts: "alert/getAlerts"
    })
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/blocks/fixed-alerts-block";
</style>
