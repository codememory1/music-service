<template>
  <div class="calendar-footer">
    <base-calendar-button class="cancel" @click="$emit('cancel', $event)">
      Cancel
    </base-calendar-button>
    <base-calendar-button class="done" @click="$emit('done', $event)">
      Done
    </base-calendar-button>
  </div>
</template>

<script>
import BaseCalendarButton from "./BaseCalendarButton";

export default {
  name: "BaseCalendarFooter",
  components: {
    BaseCalendarButton
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/calendars/base-calendar-footer";
</style>
