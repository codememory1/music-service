<template>
  <div class="calendar-days-week">
    <span class="calendar__day-week">{{ $t('day_week_shortcut.monday') }}</span>
    <span class="calendar__day-week">{{ $t('day_week_shortcut.tuesday') }}</span>
    <span class="calendar__day-week">{{ $t('day_week_shortcut.wednesday') }}</span>
    <span class="calendar__day-week">{{ $t('day_week_shortcut.thursday') }}</span>
    <span class="calendar__day-week">{{ $t('day_week_shortcut.friday') }}</span>
    <span class="calendar__day-week">{{ $t('day_week_shortcut.saturday') }}</span>
    <span class="calendar__day-week">{{ $t('day_week_shortcut.sunday') }}</span>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class BaseCalendarDaysWeek extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/calendar/base-calendar-days-week';
</style>
