<template>
  <div class="security-modal-form-field" :class="{ active: !isEmpty(value) }">
    <label :for="id">{{ label }}</label>
    <input
      :type="type"
      :id="id"
      :value="value"
      @input="$emit('input', $event.target.value)"
    />
    <i class="fas" :class="faClass"></i>
  </div>
</template>

<script>
import { generateRandomString } from "generate-strings";

export default {
  name: "SecurityModalFormField",
  props: {
    /**
     * Input type
     */
    type: {
      type: String,
      default: "text"
    },

    /**
     * Label input
     */
    label: {
      type: String,
      required: true
    },

    /**
     * Icon class fa without thickness class
     */
    faClass: {
      type: String,
      required: true
    },

    /**
     * Input value
     */
    value: {
      type: [String, Number],
      default: null
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

<style lang="scss">
@import "../../../scss/components/form-fields/security-modal-form-field";
</style>
