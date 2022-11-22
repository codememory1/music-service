<template>
  <div class="op-header-user-info">
    <div class="op-header__notification">
      <BaseButton class="op-header__notification-btn unread">
        <i class="far fa-bell" />
      </BaseButton>
    </div>
    <div class="op-header__user">
      <img class="op-header__user-photo" src="/images/user.png" alt="" />
      <i class="op-header__user-chevron fas fa-chevron-down" />
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
export default class OPHeaderUserInfo extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/header/op-header-user-info';
</style>
