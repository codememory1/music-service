<template>
  <transition name="fade">
    <div v-show="isOpen" class="calendar">
      <div class="calendar-top-control">
        <BaseButton class="calendar__prev-next-month-btn calendar__prev-month-btn" @click="prev">
          <i class="far fa-chevron-left" />
        </BaseButton>
        <span class="calendar-date">
          {{ monthNames[startCalendarFromDate.month - 1] }} {{ startCalendarFromDate.year }}
        </span>
        <BaseButton class="calendar__prev-next-month-btn calendar__next-month-btn" @click="next">
          <i class="far fa-chevron-right" />
        </BaseButton>
      </div>
      <div class="calendar-content">
        <BaseCalendarDaysWeek />

        <div class="calendar-days">
          <span v-for="step in steps" :key="step.id" class="calendar-day" />
          <BaseCalendarPick
            v-for="pickItem in picks"
            :key="pickItem.day"
            :pick="pickItem"
            :active="isActive(pickItem)"
            @click="pick(pickItem)"
          />
        </div>
      </div>
      <div class="calendar-down-control">
        <BaseButton class="calendar-down-control__btn calendar__clear-btn" @click="clear">
          {{ $t('common.clear') }}
        </BaseButton>
        <BaseButton
          class="button_bg--blue calendar-down-control__btn calendar__down-btn"
          @click="done"
        >
          {{ $t('common.done') }}
        </BaseButton>
      </div>
    </div>
  </transition>
</template>

<script lang="ts">
import { Component, Emit, Prop, Vue } from 'vue-property-decorator';
import BaseCalendarDaysWeek from '~/components/Business/Calendar/BaseCalendarDaysWeek.vue';
import BaseCalendarPick from '~/components/Business/Calendar/BaseCalendarPick.vue';
import BaseButton from '~/components/UI/Button/BaseButton.vue';
import { CalendarDateType, CalendarPickType, CalendarPickSteep } from '~/types/Calendar';
const { v4: uuidv4 } = require('uuid');

@Component({
  components: {
    BaseCalendarDaysWeek,
    BaseCalendarPick,
    BaseButton
  }
})
export default class BaseCalendar extends Vue {
  @Prop({ required: false })
  private readonly year?: number;

  @Prop({ required: false })
  private readonly month?: number;

  @Prop({ required: false })
  private readonly day?: number;

  private isOpen: boolean = false;
  private monthNames: Array<string> = [
    this.$t('month.january'),
    this.$t('month.february'),
    this.$t('month.march'),
    this.$t('month.april'),
    this.$t('month.may'),
    this.$t('month.june'),
    this.$t('month.july'),
    this.$t('month.august'),
    this.$t('month.september'),
    this.$t('month.october'),
    this.$t('month.november'),
    this.$t('month.december')
  ];

  private startCalendarFromDate: CalendarDateType = {
    year: this.year,
    month: this.month,
    day: this.day
  };

  private picked: CalendarDateType = {
    year: this.year,
    month: this.month,
    day: this.day
  };

  private picks!: Array<CalendarPickType>;

  private created(): void {
    const date = new Date();

    if (undefined === this.startCalendarFromDate.year) {
      this.startCalendarFromDate.year = date.getFullYear();
      this.picked.year = date.getFullYear();
    }

    if (undefined === this.startCalendarFromDate.month) {
      this.startCalendarFromDate.month = date.getMonth() + 1;
      this.picked.month = date.getMonth() + 1;
    }

    if (undefined === this.startCalendarFromDate.day) {
      this.startCalendarFromDate.day = date.getDate();
      this.picked.day = date.getDate();
    }

    this.picks = this.build();
  }

  private get steps(): Array<CalendarPickSteep> {
    const steps = [];

    for (let i = 0; i < this.dayWeekStartOfMonth - 1; i++) {
      steps.push({ id: uuidv4() });
    }

    return steps;
  }

  private static getDayOfWeek(date: Date): number {
    return date.getDay() === 0 ? 7 : date.getDay();
  }

  private isActive(pick: CalendarPickType): boolean {
    return (
      this.startCalendarFromDate.year === this.picked.year &&
      this.startCalendarFromDate.month === this.picked.month &&
      pick.day === this.picked.day
    );
  }

  private get dayWeekStartOfMonth(): number {
    const date = new Date(
      this.startCalendarFromDate.year!,
      this.startCalendarFromDate.month! - 1,
      1
    );

    return date.getDay();
  }

  private build(): Array<CalendarPickType> {
    const picks: Array<CalendarPickType> = [];
    const zeroDate = new Date(
      this.startCalendarFromDate.year!,
      this.startCalendarFromDate.month!,
      0
    );

    for (let i = 1; i <= zeroDate.getDate(); i++) {
      picks.push({ day: i });
    }

    return picks;
  }

  private prev(): void {
    if (this.startCalendarFromDate.month === 1) {
      this.startCalendarFromDate.year = this.startCalendarFromDate.year! - 1;
      this.startCalendarFromDate.month = 12;
    } else {
      this.startCalendarFromDate.month = this.startCalendarFromDate.month! - 1;
    }

    this.picks = this.build();

    this.$emit('prev', this.startCalendarFromDate);
  }

  private next(): void {
    if (this.startCalendarFromDate.month === 12) {
      this.startCalendarFromDate.year = this.startCalendarFromDate.year! + 1;
      this.startCalendarFromDate.month = 1;
    } else {
      this.startCalendarFromDate.month = this.startCalendarFromDate.month! + 1;
    }

    this.picks = this.build();

    this.$emit('next', this.startCalendarFromDate);
  }

  private pick(pick: CalendarPickType): void {
    this.picked.year = this.startCalendarFromDate.year;
    this.picked.month = this.startCalendarFromDate.month;
    this.picked.day = pick.day;

    this.$emit('pick', this.picked);
  }

  @Emit('clear')
  private clear(): void {
    this.picked.year = undefined;
    this.picked.month = undefined;
    this.picked.day = undefined;
  }

  @Emit('open')
  private open(): void {
    this.isOpen = true;
  }

  @Emit('done')
  private done(): void {
    this.isOpen = false;

    this.pick({
      day: this.startCalendarFromDate.day!
    });
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/calendar/base-calendar';
</style>
