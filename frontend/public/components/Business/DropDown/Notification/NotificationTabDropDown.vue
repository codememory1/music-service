<template>
  <div class="notification-drop-down-tab">
    <ul class="notification-drop-down-tab-items">
      <li
        v-for="(tab, index) in tabs"
        :key="index"
        class="notification-drop-down-tab__item"
        :class="{ active: index === activeTab }"
        @click="selectTab(index)"
      >
        <BaseButton class="notification-drop-down-tab__item-btn">
          {{ tab.title }}
          <span v-if="tab.unread > 0" class="notification-drop-down-tab__unread">
            {{ tab.unread }}
          </span>
        </BaseButton>
      </li>
    </ul>
    <BaseButton class="notification-drop-down-tab__settings-btn">
      <i class="fal fa-cog" />
    </BaseButton>
  </div>
</template>

<script lang="ts">
import { Component, VModel, Vue } from 'vue-property-decorator';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import NotificationTabType from '~/types/ui/notification/notification-tab-type';

@Component({
  components: {
    BaseButton
  }
})
export default class NotificationTabDropDown extends Vue {
  private tabs: Array<NotificationTabType> = [];

  @VModel({ required: true })
  private activeTab!: number;

  public created(): void {
    this.tabs = [
      {
        title: 'All',
        unread: 0
      },
      {
        title: 'System',
        unread: 0
      },
      {
        title: 'Friends',
        unread: 0
      }
    ];
  }

  private selectTab(index: number): void {
    this.activeTab = index;

    this.$emit('click', index);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/drop-down/notification/notification-tab-drop-down.scss';
</style>
