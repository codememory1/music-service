<template>
  <div class="wp-header-search">
    <i class="wp-header-search__icon fal fa-search" />
    <input
      type="text"
      class="wp-header-search__input"
      :placeholder="$t('placeholder.search')"
      @input="$emit('search', $event)"
    />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseInput from '~/components/UI/FormElements/Input/BaseInput.vue';

@Component({
  components: {
    BaseInput
  }
})
export default class TheSearchWebPlayerHeader extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/header/wp-search-header.scss';
</style>
