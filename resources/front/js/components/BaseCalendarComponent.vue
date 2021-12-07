<template>
  <div class="calendar">
    <div class="calendar__content">
      <div class="calendar__header">
        <div class="calendar__button calendar_button_header" @click="prev">
          <svg-alias alias="arrow-left-svg" />
        </div>
        <div class="month">
          <span class="month__name"
            >{{ months[displayedData.month - 1] }}
            {{ displayedData.year }}</span
          >
        </div>
        <div class="calendar__button calendar_button_header" @click="next">
          <svg-alias alias="arrow-right-svg" />
        </div>
      </div>
      <div class="calendar__days-week">
        <span>Mo</span>
        <span>Tu</span>
        <span>We</span>
        <span>Th</span>
        <span>Fri</span>
        <span>Sa</span>
        <span>Su</span>
      </div>
      <div class="calendar__days">
        <span
          class="disabled"
          v-for="(_, index) in this.startedFromWeek"
          :key="index"
        ></span>
        <span
          v-for="(day, index) in date.getDate()"
          :class="{ active: day === displayedData.day }"
          :key="index"
          @click="datePicker"
          >{{ day }}</span
        >
      </div>
    </div>
    <div class="calendar__footer">
      <div class="calendar__button calendar_button_cancel" @click="cancel">
        Cancel
      </div>
      <div class="calendar__button calendar_button_done" @click="done">
        Done
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "BaseCalendar",
  props: {
    /**
     * Default active year
     *
     * @type {Number}
     */
    activeYear: {
      type: Number,
      default: new Date().getFullYear(),
      required: false
    },

    /**
     * Default active month
     *
     * @type {Number}
     */
    activeMonth: {
      type: Number,
      default: new Date().getMonth() + 1,
      required: false
    },

    /**
     * Default active day
     *
     * @type {Number}
     */
    activeDay: {
      type: Number,
      default: new Date().getDate(),
      required: false
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
    startedFromWeek: 1
  }),

  created() {
    this.initDisplayedData();
    this.dateInit();

    this.startedFromWeek = this.definingDayOfWeek(
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

      this.startedFromWeek = this.definingDayOfWeek(
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
@import "../../scss/components/calendar";
</style>
