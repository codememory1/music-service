<template>
  <security-modal ref="securityModal" title="Password Recovery">
    <!-- Code entry fields START -->
    <template v-slot:contentAfterTitle>
      <div class="code__items">
        <div
          v-for="(item, index) in code"
          :key="index"
          class="code__item"
          :class="{ active: activeIndexCode === index }"
        >
          <input
            type="text"
            ref="item"
            @input="changeCode(index, $event.target.value, $event.target)"
            @click="activeIndexCode = index"
          />
        </div>
      </div>
    </template>
    <!-- Code entry fields END -->

    <!-- Form START -->
    <template v-slot:form>
      <security-modal-form button-label="Change password">
        <security-form-field
          label="Password"
          icon-class="fa-key"
          v-model="password"
        />
        <security-form-field
          label="Repeat password"
          icon-class="fa-key"
          v-model="repeatPassword"
        />
      </security-modal-form>
    </template>
    <!-- Form END -->
  </security-modal>
</template>
<script>
import SecurityModal from "./SecurityModalComponent";
import SecurityModalForm from "./SecurityModalFormComponent";
import SecurityFormField from "./SecurityFormFieldComponent";

export default {
  name: "PasswordRecoverModal",
  components: {
    SecurityModal,
    SecurityModalForm,
    SecurityFormField
  },

  data: () => ({
    password: null,
    repeatPassword: null,
    code: [null, null, null, null, null, null],
    activeIndexCode: null
  }),

  methods: {
    /**
     * Opening a window
     */
    open() {
      this.$refs.securityModal.open();
    },

    /**
     * Closing the window
     */
    close() {
      this.$refs.securityModal.close();
    },

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
<style lang="scss" scoped>
@import "../../../scss/variables";

.code {
  &__items {
    display: flex;
    margin-bottom: 35px;
  }

  &__item {
    max-width: 40px;
    max-height: 40px;
    width: 40px;
    height: 40px;
    background-color: $dark-bg;
    border-radius: 5px;
    margin-right: 20px;
    cursor: text;

    &:last-of-type {
      margin-right: 0;
    }

    &.active {
      border: 1px solid $accent;
    }

    input {
      width: inherit;
      height: inherit;
      background: transparent;
      border: none;
      outline: none;
      color: #fff;
      font-size: 16px;
      font-weight: 500;
      text-align: center;
    }
  }
}
</style>
