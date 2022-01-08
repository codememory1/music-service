<template>
  <base-button class="calendar__button" @click="$emit('click', $event)">
    <slot />
  </base-button>
</template>

<script>
import BaseButton from "../Buttons/BaseButton";

export default {
  name: "BaseCalendarButton",
  components: {
    BaseButton
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/calendars/base-calendar-button";
</style>
