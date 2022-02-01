<template>
  <div class="code-field__items">
    <span
      v-for="(_, index) in code"
      class="code-field__item"
      :key="index"
      :class="{ active: activeIndexCode === index }"
    >
      <input
        type="text"
        ref="item"
        @input="changeCode(index, $event.target.value, $event.target)"
        @click="activeIndexCode = index"
      />
    </span>
  </div>
</template>

<script>
export default {
  name: "CodeField",
  props: {
    /**
     * Maximum number of inputs
     */
    maxNumber: {
      type: Number,
      required: true
    }
  },

  data: () => ({
    code: [],
    activeIndexCode: null
  }),

  created() {
    for (let i = 0; i < this.maxNumber; i++) {
      this.code.push(null);
    }
  },

  methods: {
    /**
     * Handler when entering code
     *
     * @param index
     * @param value
     * @param target
     */
    changeCode(index, value, target) {
      if (value.length > 1) {
        target.value = value.substring(0, 1);
      } else {
        this.code[index] = value;

        this.focus(index);
      }
    },

    /**
     * Getting a code as a single number
     *
     * @returns {number}
     */
    getCode() {
      return Number(this.code.join(""));
    },

    /**
     * Focus handler to the following code
     *
     * @param index
     */
    focus(index) {
      if (!this.isEmpty(this.code[index])) {
        this.activeIndexCode++;

        this.$refs.item[this.activeIndexCode]?.focus();
      }
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/form-fields/code-field";
</style>
