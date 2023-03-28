<template>
  <div class="wp-content-tab">
    <div class="wp-content-tab-items">
      <WebPlayerContentItemTab
        v-for="(tab, index) in tabs"
        :key="index"
        :title="tab"
        :active="activeTab === index"
        @click="activeTab = index"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, VModel, Vue } from 'vue-property-decorator';
import WebPlayerContentItemTab from '~/components/Business/Tab/WebPlayerContent/WebPlayerContentItemTab.vue';

@Component({
  components: {
    WebPlayerContentItemTab
  }
})
export default class WebPlayerContentTab extends Vue {
  @Prop({ required: true, default: () => [] })
  private readonly tabs!: Array<string>;

  @VModel({ required: false, default: 0 })
  private activeTab!: number;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/tab/web-player-content/web-player-content-tab.scss';
</style>
