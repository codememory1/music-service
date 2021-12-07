<template>
  <div class="select">
    <div class="select__combobox">
      <!-- Selected options START -->
      <div class="selected__options" @click="openClose">
        <slot
          v-if="selected.length === 1"
          name="selectedLabel"
          :option="getOptionData(selected[0])"
        >
          <span class="selected__text">{{
            getOptionData(selected[0]).label
          }}</span>
        </slot>
        <div v-else-if="selected.length > 1" class="selected__text">
          <slot name="tags" :selected="selected">
            <span
              v-for="(tag, index) in selected"
              :key="index"
              class="selected__tag"
            >
              {{ getOptionData(tag).label }}
              <i @click="removeFromSelected(tag)" class="fal fa-times"></i>
            </span>
          </slot>
        </div>
        <span v-if="selected.length === 0" class="selected__text placeholder">{{
          placeholder
        }}</span>
        <div class="select__actions">
          <svg-alias alias="arrow-right-svg" class="select__arrow" />
        </div>
      </div>
      <!-- Selected options END -->

      <!-- List options START -->
      <transition name="fade">
        <div
          v-show="isOpen"
          ref="listOptions"
          class="list__options"
          :class="{ top: listOptionsIsTop }"
        >
          <div v-if="withSearch" class="input-search__wrap">
            <input
              type="text"
              class="input__search"
              placeholder="Search..."
              @input="search"
            />
            <svg-alias alias="search-svg" />
          </div>
          <ul class="options">
            <li
              class="option"
              v-for="(option, index) in getOptions"
              :key="index"
              :class="{
                active: selected.includes(option.value),
                disabled:
                  maxSelections === selected.length &&
                  !selected.includes(option.value)
              }"
              @click="clickByOption(option)"
            >
              {{ option.label }}
            </li>
          </ul>
        </div>
      </transition>
      <!-- List options END -->
    </div>
  </div>
</template>
<script>
export default {
  name: "BaseSelect",
  props: {
    /**
     * Default text
     *
     * @type {String}
     */
    placeholder: {
      type: String,
      required: true
    },

    /**
     * Array of objects with keys label, value
     * Ex. {label: 'Displayed value', value: 'Value to be sent to the server'}
     *
     * @type {Array}
     */
    options: {
      type: Array,
      required: true
    },

    /**
     * Array of values from options that will be selected by default
     *
     * @type {Array}
     */
    selectedOptions: {
      type: Array,
      default: () => [],
      required: false
    },

    /**
     * Make select with search input
     *
     * @type {Boolean}
     */
    withSearch: {
      type: Boolean,
      default: false,
      required: false
    },

    /**
     * Make multi select - multiple choices of options
     *
     * @type {Boolean}
     */
    multiple: {
      type: Boolean,
      default: false,
      required: false
    },

    /**
     * Maximum number of elections
     *
     * @type {Number}
     */
    maxSelections: {
      type: Number,
      required: false
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

    if (this.selected.length === 0) {
      this.selected.push(this.getOptions[0].value);
    }

    document.addEventListener("click", () => {
      this.isOpen = false;
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
@import "../../../scss/components/select";
</style>
