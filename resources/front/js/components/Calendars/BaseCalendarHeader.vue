<template>
  <div class="calendar-header">
    <base-calendar-button class="prev" @click="$emit('prev', $event)">
      <svg-alias alias="arrow-left-svg" />
    </base-calendar-button>

    <span class="calendar__month-name"> {{ monthName }} {{ year }} </span>

    <base-calendar-button class="next" @click="$emit('next', $event)">
      <svg-alias alias="arrow-right-svg" />
    </base-calendar-button>
  </div>
</template>

<script>
import BaseCalendarButton from "./BaseCalendarButton";

export default {
  name: "BaseCalendarHeader",
  components: {
    BaseCalendarButton
  },
  props: {
    /**
     * Full month name
     */
    monthName: {
      type: String,
      required: true
    },

    /**
     * Full year
     */
    year: {
      type: Number,
      required: true
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/calendars/base-calendar-header";
</style>
