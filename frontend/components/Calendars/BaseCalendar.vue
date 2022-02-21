<template>
  <div class="calendar">
    <base-calendar-head month="" year=""/>

    <base-calendar-days-week :days-week="[]" />

    <base-calendar-days :days="[]"/>
  </div>
</template>

<script>
import BaseCalendarHead from "@/components/Calendars/BaseCalendarHead";
import BaseCalendarDaysWeek from "@/components/Calendars/BaseCalendarDaysWeek";
import BaseCalendarDays from "@/components/Calendars/BaseCalendarDays";

export default {
  name: "BaseCalendar",
  components: {
    BaseCalendarHead,
    BaseCalendarDaysWeek,
    BaseCalendarDays
  }
};
</script>
