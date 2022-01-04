<template>
  <form class="security-form" @submit.prevent>
    <slot />
    <div class="security-button-wrapper">
      <loading-button
        class="security-form__button bg--accent"
        @click="$emit('click')"
        :is-loading="btnIsLoading"
      >
        {{ buttonLabel }}
      </loading-button>
    </div>
  </form>
</template>
<script>
import LoadingButton from "../Buttons/LoadingButtonComponent";

export default {
  name: "SecurityModalForm",

  components: {
    LoadingButton
  },

  props: {
    /**
     * Button text
     *
     * @type {String}
     */
    buttonLabel: {
      type: String,
      required: true
    },

    /**
     * Show loader on button
     *
     * @type {Boolean}
     */
    btnIsLoading: {
      type: Boolean,
      default: false,
      required: false
    }
  }
};
</script>
<style lang="scss" scoped>
.security-button-wrapper {
  display: flex;
  justify-content: center;
  padding-bottom: 45px;
}

.security-form__button {
  border-radius: 60px;
  padding: 14px 30px;
  font-weight: 500;
}
</style>
