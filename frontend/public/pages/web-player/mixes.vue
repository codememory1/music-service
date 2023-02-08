<template>
  <main>
    <div class="wp-container">
      <div class="wp-mt-of-header">
        <MixSection
          :title="$t('section.titles.top_mixes_from_platform', { platform_name: $config.title })"
          :mixes="topMixesFromPlatform"
        />
      </div>
      <div class="wp-mt">
        <MixSection
          :title="$t('section.titles.top_mixes_from_top_artists')"
          :mixes="topMixesFromArtists"
        />
      </div>
      <div class="wp-mt">
        <MixSection :title="$t('section.titles.top_mixes_from_users')" :mixes="topMixesFromUsers" />
      </div>
    </div>
  </main>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import MixSection from '~/components/Business/Section/MixSection.vue';
import MixCardResponseInterface from '~/interfaces/business/api-responses/mix-card-response-interface';
import mocks from '~/api/mocks';

@Component({
  layout: 'WebPlayerLayout',
  components: {
    MixSection
  }
})
export default class Mixes extends Vue {
  private get topMixesFromPlatform(): Array<MixCardResponseInterface> {
    return mocks.mixes; // FIX: Изменить на реальные данные, которые возвращают топ миксы от Sumron Music
  }

  private get topMixesFromArtists(): Array<MixCardResponseInterface> {
    return mocks.mixes; // FIX: Изменить на реальные данные, которые возвращают топ миксы от Артистов
  }

  private get topMixesFromUsers(): Array<MixCardResponseInterface> {
    return mocks.mixes; // FIX: Изменить на реальные данные, которые возвращают топ миксы от Пользователей
  }
}
</script>
