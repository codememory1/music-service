<template>
  <div class="notification">
    <div class="notification__user-photo">
      <img src="/public/images/user.png" :alt="userName" />
    </div>
    <div class="notification__content">
      <div class="notification__content--top">
        <span class="notification__user-name">{{ userName }}</span>
        <span class="notification__create-at">{{ createdAt }}</span>
      </div>
      <div class="notification__content--down">
        <p class="notification__description">{{ description }}</p>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "BaseNotification",
  props: {
    /**
     * @type {String}
     */
    userName: {
      type: String,
      required: true
    },

    /**
     * @type {String}
     */
    userPhoto: {
      type: String,
      required: true
    },

    /**
     * @type {Boolean}
     */
    isOnline: {
      type: Boolean,
      default: false,
      required: false
    },

    /**
     * @type {String}
     */
    createdAt: {
      type: String,
      required: true
    },

    /**
     * @type {String}
     */
    description: {
      type: String,
      required: true
    }
  }
};
</script>
<style lang="scss">
@import "../../scss/components/notification";
</style>
