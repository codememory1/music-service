<template>
  <BaseButton class="calendar-day" :class="{ active }" @click="$emit('click', $event)">
    {{ pick.day }}
  </BaseButton>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import { CalendarPickType } from '~/types/Calendar';
import BaseButton from '~/components/UI/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class BaseCalendarPick extends Vue {
  @Prop({ required: true })
  private readonly pick!: CalendarPickType;

  @Prop({ required: false, default: false })
  private readonly active!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/business/calendar/base-calendar-pick.scss';
</style>
