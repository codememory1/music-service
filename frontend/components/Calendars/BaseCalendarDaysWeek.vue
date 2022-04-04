<template>
  <div class="calendar-days-week">
    <span
      v-for="(dayWeek, index) in daysWeek"
      class="calendar__day-week"
      :key="index"
    >
      {{ dayWeek }}
    </span>
  </div>
</template>

<script>
import {arrayValidator} from "~/node_modules/vue-props-validation/src";

export default {
  name: "BaseCalendarDaysWeek",
  props: {
    daysWeek: {
      type: Array,
      validator: arrayValidator({
        type: String
      }),
      required: true
    },
  }
};
</script>
