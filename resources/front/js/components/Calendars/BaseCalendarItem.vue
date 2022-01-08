<template>
  <span
    v-if="undefined === label"
    class="calendar__day disabled"
    :aria-disabled="true"
  ></span>
  <span
    v-else
    role="button"
    class="calendar__day"
    :class="{ active: isActive }"
    :aria-disabled="false"
    :aria-current="isCurrentDate ? 'date' : 'false'"
    :aria-selected="isCurrentDate ? 'true' : 'false'"
    :tabindex="isCurrentDate ? '0' : '-1'"
    @click="$emit('datePicker', $event)"
  >
    {{ label }}
  </span>
</template>

<script>
export default {
  name: "BaseCalendarItem",
  props: {
    /**
     * Label or empty if disabled
     */
    label: {
      type: [Number],
      required: false
    },

    /**
     * Is active item, If label is not empty
     */
    isActive: {
      type: Boolean,
      default: false
    },

    /**
     * Is aria current date
     */
    isCurrentDate: {
      type: Boolean,
      default: false
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/calendars/base-calendar-item";
</style>
