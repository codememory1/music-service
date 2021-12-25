<template>
  <div class="alerts">
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
  name: "BlockAlerts",
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
.alerts {
  position: fixed;
  top: 50px;
  right: 50px;
  display: flex;
  flex-direction: column;
  z-index: 9999;

  div.alert {
    margin: 7.5px 0;
  }
}

.alert-fade-enter-active,
.alert-fade-leave-active {
  transition: all 0.5s ease;
  opacity: 1;
}

.alert-fade-enter,
.alert-fade-leave-to {
  transition: all 0.5s ease;
  opacity: 0;
}
</style>
