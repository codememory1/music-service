<template>
  <div class="calendar-head">
    <button class="calendar__button prev">
      <svg-alias alias="arrow-left"/>
    </button>
    <span class="calendar__month-name">{{ month }} {{ year }}</span>
    <button class="calendar__button next">
      <svg-alias alias="arrow-right"/>
    </button>
  </div>
</template>

<script>
export default {
  name: "BaseCalendarHead",
  props: {
    month: {
      type: String,
      required: true
    },

    year: {
      type: Number,
      required: true
    }
  }
};
</script>
