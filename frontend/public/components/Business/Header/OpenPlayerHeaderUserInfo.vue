<template>
  <div class="open-player-header-user-info">
    <div class="open-player-header__notification">
      <BaseButton class="open-player-header__notification-btn unread">
        <i class="far fa-bell" />
      </BaseButton>
    </div>
    <div class="open-player-header__user">
      <img class="open-player-header__user-photo" src="/images/user.png" alt="" />
      <i class="open-player-header__user-chevron fas fa-chevron-down" />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseButton from '~/components/UI/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class OpenPlayerHeaderUserInfo extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/header/open-player-header-user-info';
</style>
