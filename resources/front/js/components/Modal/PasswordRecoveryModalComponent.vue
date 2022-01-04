<template>
  <security-modal ref="securityModal" title="Password Recovery">
    <!-- Code entry fields START -->
    <template v-slot:contentAfterTitle>
      <div class="code-items">
        <span
          v-for="(_, index) in code"
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
        </span>
      </div>
    </template>
    <!-- Code entry fields END -->

    <!-- Form START -->
    <template v-slot:form>
      <security-modal-form button-label="Change password">
        <security-modal-field
          label="Password"
          icon-class="fa-key"
          v-model="password"
        />
        <security-modal-field
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
import SecurityModalForm from "../Forms/SecurityModalFormComponent";
import SecurityModalField from "../Fields/SecurityModalFieldComponent";

export default {
  name: "PasswordRecoverModalComponent",
  components: {
    SecurityModal,
    SecurityModalForm,
    SecurityModalField
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
@import "../../../scss/components/modals/passwordRecovery";
</style>
