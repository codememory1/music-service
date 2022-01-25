<template>
  <div class="calendar" aria-label="Calendar">
    <div class="calendar-content">
      <base-calendar-header
        :month-name="months[displayedData.month - 1]"
        :year="displayedData.year"
        @prev="prev"
        @next="next"
      />

      <base-calendar-days-week />

      <!-- Days START -->
      <div class="calendar-days">
        <!-- Empty item -->
        <base-calendar-item
          v-for="(_, index) in startedFromDayWeek"
          :key="index"
        />

        <!-- Not empty item -->
        <base-calendar-item
          v-for="(day, index) in date.getDate()"
          :key="index"
          :label="day"
          :is-active="day === displayedData.day"
          :is-current-date="day === displayedData.day"
          @datePicker="datePicker"
        />
      </div>
      <!-- Days END -->
    </div>

    <base-calendar-footer @done="done" @cancel="cancel" />
  </div>
</template>

<script>
import BaseCalendarHeader from "./BaseCalendarHeader";
import BaseCalendarDaysWeek from "./BaseCalendarDaysWeek";
import BaseCalendarItem from "./BaseCalendarItem";
import BaseCalendarFooter from "./BaseCalendarFooter";

export default {
  name: "BaseCalendar",
  components: {
    BaseCalendarHeader,
    BaseCalendarDaysWeek,
    BaseCalendarItem,
    BaseCalendarFooter
  },
  props: {
    /**
     * Default active year
     */
    activeYear: {
      type: Number,
      default: new Date().getFullYear()
    },

    /**
     * Default active month
     */
    activeMonth: {
      type: Number,
      default: new Date().getMonth() + 1
    },

    /**
     * Default active day
     */
    activeDay: {
      type: Number,
      default: new Date().getDate()
    }
  },

  data: () => ({
    date: null,
    months: [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December"
    ],
    displayedData: {
      year: null,
      month: null,
      day: null
    },
    startedFromDayWeek: 1
  }),

  created() {
    this.initDisplayedData();
    this.dateInit();

    this.startedFromDayWeek = this.definingDayOfWeek(
      1,
      this.displayedData.month,
      this.displayedData.year
    );
  },

  methods: {
    /**
     * Initializing a Date Object
     */
    dateInit() {
      this.date = new Date(
        this.displayedData.year,
        this.displayedData.month,
        0
      );
    },

    /**
     * Initializing data for display
     */
    initDisplayedData() {
      this.displayedData.year = this.activeYear;
      this.displayedData.month = this.activeMonth;
      this.displayedData.day = this.activeDay;
    },

    /**
     * Getting the day of the week - 1
     *
     * @param day {Number}
     * @param month {Number}
     * @param year {Number}
     *
     * @returns {number}
     */
    definingDayOfWeek(day, month, year) {
      const date = new Date(year, month - 1, day);
      const dayOfWeek = date.getDay();

      if (dayOfWeek === 0) {
        return 6;
      }

      return dayOfWeek - 1;
    },

    /**
     * Handling an event when clicking on a number
     *
     * @param event
     */
    datePicker(event) {
      this.displayedData.day = Number(event.target.textContent);

      this.$emit("datePicker");
    },

    /**
     * Event handling when clicking on the "prev" arrow
     */
    prev() {
      if (this.displayedData.month <= 1) {
        this.displayedData.year--;
        this.displayedData.month = 12;
      } else {
        this.displayedData.month--;
      }

      this.genericSwipeHandler("prev");
    },

    /**
     * Event handling when clicking on the "next" arrow
     */
    next() {
      if (this.displayedData.month >= 12) {
        this.displayedData.year++;
        this.displayedData.month = 1;
      } else {
        this.displayedData.month++;
      }

      this.genericSwipeHandler("next");
    },

    /**
     * Generic handler when clicking on prev or next
     *
     * @param eventName {String}
     */
    genericSwipeHandler(eventName) {
      this.dateInit();

      this.startedFromDayWeek = this.definingDayOfWeek(
        1,
        this.displayedData.month,
        this.displayedData.year
      );

      this.$emit(eventName);
    },

    /**
     * Event handler for the done button
     */
    done() {
      this.$emit("done", this.displayedData);
    },

    /**
     * Event handler for the cancel button
     */
    cancel() {
      this.$emit("cancel", this);
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/calendars/base-calendar";
</style>
