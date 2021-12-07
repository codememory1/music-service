<template>
  <form class="security__form" @submit.prevent>
    <slot />
    <div class="security__button_wrap">
      <base-form-button class="security__button accent" @click="$emit('click')">
        {{ buttonLabel }}
      </base-form-button>
    </div>
  </form>
</template>
<script>
import BaseFormButton from "../Buttons/BaseFormButtonComponent";

export default {
  name: "SecurityModalForm",

  components: {
    BaseFormButton
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
    }
  }
};
</script>
<style lang="scss" scoped>
.security__button_wrap {
  display: flex;
  justify-content: center;
  padding-bottom: 45px;
}

.security__button {
  border-radius: 60px;
  padding: 14px 30px;
  font-weight: 500;
}
</style>
