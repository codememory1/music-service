<template>
  <div class="security-form-field" :class="{ active: !isEmpty(value) }">
    <label :for="id">{{ label }}</label>
    <input
      :type="type"
      :id="id"
      :value="value"
      @input="$emit('input', $event.target.value)"
    />
    <i class="fas" :class="iconClass"></i>
  </div>
</template>
<script>
import { generateRandomString } from "generate-strings";

export default {
  name: "SecurityModalFieldComponent",
  props: {
    /**
     * Label input
     *
     * @type {String}
     */
    label: {
      type: String,
      required: true
    },

    /**
     * Icon class fa without thickness class
     *
     * @type {String}
     */
    iconClass: {
      type: String,
      required: true
    },

    /**
     * Input type
     *
     * @type {String}
     */
    type: {
      type: String,
      default: "text",
      required: false
    },

    value: {
      type: [String, Number],
      default: null,
      required: false
    }
  },

  model: {
    prop: "value",
    event: "input"
  },

  data: () => ({
    id: null
  }),

  created() {
    this.id = generateRandomString();
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/components/fields/securityModal";
</style>
