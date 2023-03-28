<template>
  <BaseButton class="wp-content-tab__item" :class="{ blue: active }" @click="$emit('click')">
    {{ title }}
  </BaseButton>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class WebPlayerContentItemTab extends Vue {
  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: false, default: false })
  private readonly active!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/tab/web-player-content/web-player-content-item-tab.scss';
</style>
