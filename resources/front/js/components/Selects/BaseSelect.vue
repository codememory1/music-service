<template>
  <div class="select" ref="baseCustomSelect">
    <div class="select-combobox">
      <!-- Selected options START -->
      <div class="select-selected-options" @click="openClose">
        <!-- One item selected START -->
        <slot
          v-if="selected.length === 1"
          name="selectedLabel"
          :option="getOptionData(selected[0])"
        >
          <span class="select-selected__text">
            {{ getOptionData(selected[0]).label }}
          </span>
        </slot>
        <!-- One item selected END -->

        <!-- > One item selected START -->
        <div v-else-if="selected.length > 1" class="select-selected__text">
          <slot name="tags" :selected="selected">
            <base-select-tag
              v-for="(tag, index) in selected"
              :key="index"
              :label="getOptionData(tag).label"
              @click="removeFromSelected(tag)"
            />
          </slot>
        </div>
        <!-- > One item selected END -->

        <!-- Zero item selected START -->
        <span
          v-else-if="selected.length === 0"
          class="select-selected__text select__placeholder"
        >
          {{ placeholder }}
        </span>
        <!-- Zero item selected END -->

        <div class="select-actions">
          <svg-alias alias="arrow-right-svg" class="select__arrow" />
        </div>
      </div>
      <!-- Selected options END -->

      <transition name="fade">
        <div
          v-show="isOpen"
          ref="listOptions"
          class="select-list-options"
          :class="{ top: listOptionsIsTop }"
          :aria-expanded="isOpen"
        >
          <!-- Search START -->
          <base-select-search v-if="withSearch" @input="search" />
          <!-- Search END -->

          <!-- List options START -->
          <ul class="select-options" role="listbox">
            <base-select-option
              v-for="(option, index) in getOptions"
              :key="index"
              :label="option.label"
              :is-active="selected.includes(option.value)"
              :is-disabled="
                maxSelections === selected.length &&
                !selected.includes(option.value)
              "
              @click="clickByOption(option)"
            />
          </ul>
          <!-- List options END -->
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import BaseSelectSearch from "./BaseSelectSearch";
import BaseSelectOption from "./BaseSelectOption";
import BaseSelectTag from "./BaseSelectTag";

export default {
  name: "BaseSelect",
  components: {
    BaseSelectSearch,
    BaseSelectOption,
    BaseSelectTag
  },
  props: {
    /**
     * Default text
     */
    placeholder: {
      type: String,
      required: true
    },

    /**
     * Array of objects with keys label, value
     * Ex. {label: 'Displayed value', value: 'Value to be sent to the server'}
     */
    options: {
      type: Array,
      required: true
    },

    /**
     * Array of values from options that will be selected by default
     */
    selectedOptions: {
      type: Array,
      default: () => []
    },

    /**
     * Make select with search input
     */
    withSearch: {
      type: Boolean,
      default: false
    },

    /**
     * Make multi select - multiple choices of options
     */
    multiple: {
      type: Boolean,
      default: false
    },

    /**
     * Maximum number of elections
     */
    maxSelections: {
      type: Number,
      default: 0
    }
  },

  data: () => ({
    selected: [],
    isOpen: false,
    modifiableOptions: [],
    rectListOptions: null,
    rectBody: null,
    listOptionsIsTop: false
  }),

  created() {
    this.selected = this.selectedOptions;
    this.modifiableOptions = this.options;
  },

  mounted() {
    window.addEventListener("click", (event) => {
      if (!this.$refs.baseCustomSelect?.contains(event.target)) {
        this.isOpen = false;
      }
    });
  },

  computed: {
    /**
     * Returns formatted options
     *
     * @returns {[]}
     */
    getOptions() {
      return this.getOptionsFrom(this.modifiableOptions);
    }
  },

  methods: {
    /**
     *
     * @param from {Array}
     * @returns {[]}
     */
    getOptionsFrom(from) {
      let options = [];

      from.forEach((el) => {
        if ("value" in el) {
          options.push(this.getOptionData(el.value));
        } else {
          options.push(this.getOptionData(el.label));
        }
      });

      return options;
    },

    /**
     *
     * @param value {String, Number}
     * @returns {Object}
     */
    getOptionData(value) {
      let optionsWithValue = [];
      let optionsWithoutValue = [];
      let finedOption = {};

      for (let i = 0; i < this.options.length; i++) {
        let option = this.options[i];
        option.index = i;

        if ("value" in option) {
          optionsWithValue.push(option);
        } else {
          option.value = option.label;

          optionsWithoutValue.push(option);
        }
      }

      for (let i = 0; i < optionsWithValue.length; i++) {
        const option = optionsWithValue[i];

        if (option.value === value) {
          finedOption = option;
        }
      }

      if (Object.keys(finedOption).length === 0) {
        for (let i = 0; i < optionsWithoutValue.length; i++) {
          const option = optionsWithoutValue[i];

          if (option.label === value) {
            finedOption = option;
          }
        }
      }

      return finedOption;
    },

    /**
     * Select open and close event
     */
    openClose() {
      this.isOpen = !this.isOpen;

      if (this.isOpen) {
        this.$emit("open");
      } else {
        this.modifiableOptions = this.options;

        this.$emit("close");
      }
    },

    /**
     * Option click events
     *
     * @param option {Object}
     */
    clickByOption(option) {
      if (!this.multiple) {
        this.selected = [option.value];

        this.openClose();
      } else {
        if (this.selected.includes(option.value)) {
          let indexOfSelected = this.selected.indexOf(option.value);

          if (indexOfSelected !== -1) {
            this.selected.splice(indexOfSelected, 1);
          }
        } else {
          this.selected.push(option.value);
        }
      }

      this.$emit("change", this.selected);
    },

    /**
     * Events when writing in search input
     *
     * @param event
     */
    search(event) {
      let options = [];

      this.options.forEach((el) => {
        if (el.label.search(new RegExp("^" + event.target.value, "i")) !== -1) {
          options.push(el);
        }
      });

      this.modifiableOptions = options;
    },

    /**
     * Tag close click event
     *
     * @param value
     */
    removeFromSelected(value) {
      if (this.selected.includes(value)) {
        let indexOfSelected = this.selected.indexOf(value);

        if (indexOfSelected !== -1) {
          this.selected.splice(indexOfSelected, 1);
        }
      }
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/selects/base-select";
</style>
