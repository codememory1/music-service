<template>
  <div class="security__form_field" :class="{ active: !isEmpty(value) }">
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
  name: "SecurityFormField",
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
@import "../../../scss/variables";

.security__form_field {
  position: relative;
  width: 100%;
  height: 50px;
  border: 1px solid $accent;
  border-radius: 10px;
  margin-bottom: 20px;

  &:last-of-type {
    margin-bottom: 0;
  }

  > label {
    position: absolute;
    transform: translateY(-50%);
    top: 50%;
    left: 15px;
    color: #999;
    pointer-events: none;
    background-color: $abs-light-bg;
    transition: all 0.3s ease-in-out;
    padding: 3px 7px;
  }

  input {
    width: inherit;
    height: inherit;
    background-color: transparent;
    border: none;
    outline: none;
    color: #fff;
    font-size: 15px;
    padding: 0 45px 0 15px;

    &:-webkit-autofill,
    &:-webkit-autofill:hover,
    &:-webkit-autofill:focus,
    &:-webkit-autofill:active {
      transition: background-color 5000s ease-in-out 0s;
      -webkit-text-fill-color: #fff !important;
    }
  }

  i {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 20px;
    color: lighten($abs-light-bg, 10%);
    right: 10px;
  }

  &.active {
    label {
      font-size: 14px;
      transform: translateY(-160%);
      color: #fff;
    }
  }
}

.security__form_field:focus-within {
  > label {
    font-size: 14px;
    transform: translateY(-160%);
    color: #fff;
  }
}
</style>
