<template>
  <div class="notifications">
    <transition-group name="notification-fade" mode="out-in">
      <base-notification
        v-for="(notification, index) in notifications"
        :key="index + notification.title"
        :type="notification.type"
        :title="notification.title"
        :message="notification.message"
      />
    </transition-group>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
import BaseNotification from "../../components/BaseNotificationComponent";

export default {
  name: "BlockNotifications",
  components: {
    BaseNotification
  },

  computed: {
    ...mapGetters({
      notifications: "notification/getNotifications"
    })
  }
};
</script>
<style lang="scss">
.notifications {
  position: fixed;
  top: 50px;
  right: 50px;
  display: flex;
  flex-direction: column;
  z-index: 9999;

  div.notification {
    margin: 7.5px 0;
  }
}

.notification-fade-enter-active,
.notification-fade-leave-active {
  transition: all 0.5s ease;
  opacity: 1;
}

.notification-fade-enter,
.notification-fade-leave-to {
  transition: all 0.5s ease;
  opacity: 0;
}
</style>
