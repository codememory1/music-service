<template>
  <div v-if="type === 'success'" class="base-motionless-alert success">
    <i class="far fa-check"></i>
    <span>{{ message }}</span>
  </div>
  <div v-else-if="type === 'error'" class="base-motionless-alert error">
    <i class="far fa-times"></i>
    <span>{{ message }}</span>
  </div>
  <div v-else-if="type === 'warning'" class="base-motionless-alert warning">
    <i class="far fa-exclamation-triangle"></i>
    <span>{{ message }}</span>
  </div>
  <div v-else-if="type === 'info'" class="base-motionless-alert info">
    <i class="far fa-exclamation-circle"></i>
    <span>{{ message }}</span>
  </div>
</template>
<script>
export default {
  props: {
    /**
     * @type {String}
     */
    type: {
      type: String,
      required: true
    },

    /**
     * @type {String}
     */
    message: {
      type: String,
      required: true
    }
  }
};
</script>
<style lang="scss">
@import "../../scss/variables";

.base-motionless-alert {
  display: flex;
  padding: 10px;
  width: max-content;
  border-radius: 5px;
  color: #fff;
  font-weight: 500;
  align-items: center;

  > i {
    font-size: 18px;
    opacity: 0.6;
  }

  > span {
    margin-left: 10px;
    font-size: 14px;
  }

  &.success {
    background-color: #128039;
  }

  &.error {
    background-color: $red;
  }

  &.warning {
    background-color: #c17300;
  }

  &.info {
    background-color: #125280;
  }
}
</style>
