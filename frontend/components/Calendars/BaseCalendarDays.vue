<template>
  <div class="calendar-days">
    <button
      v-for="(day, index) in days"
      class="calendar__day"
      :key="index"
      :class="{
        disabled: day.isDisabled,
        active: day.isActive
      }"
    >{{ day.day }}</button>
  </div>
</template>

<script>
import {arrayValidator, objectValidator} from "~/node_modules/vue-props-validation/src";

export default {
  name: "BaseCalendarDays",
  props: {
    days: {
      type: Array,
      validator: arrayValidator({
        type: Object,
        validator: objectValidator({
          day: Number,
          isDisabled: Boolean,
          isActive: Boolean
        })
      }),
      required: true
    }
  }
};
</script>
