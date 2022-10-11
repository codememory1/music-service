<template>
  <div class="artist-profile-header">
    <img src="/images/artist-bg1.png" alt="" class="artist-profile-header__img" />

    <div class="artist-profile-header-content">
      <h1 class="artist-profile-header__name">{{ pseudonym }}</h1>
      <p class="artist-profile-header__description">{{ description }}</p>
      <div class="artist-profile-header-buttons">
        <SubscribeButton v-if="isSubscribed" />
        <UnsubscribeButton v-else />

        <ShareButton />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import ArtistHeaderSearch from '~/components/Business/Artist/Profile/ArtistProfileHeaderSearch.vue';
import SubscribeButton from '~/components/Business/Button/SubscribeButton.vue';
import UnsubscribeButton from '~/components/Business/Button/UnsubscribeButton.vue';
import ShareButton from '~/components/Business/Button/ShareButton.vue';

@Component({
  components: {
    ArtistHeaderSearch,
    SubscribeButton,
    UnsubscribeButton,
    ShareButton
  }
})
export default class ArtistProfileHeader extends Vue {
  @Prop({ required: true })
  private readonly id!: number;

  @Prop({ required: true })
  private readonly pseudonym!: string;

  @Prop({ required: true })
  private readonly description!: string;

  private isSubscribed: boolean = false;
}
</script>

<style lang="scss">
@import '@/assets/scss/business/artist/profile/artist-header';
</style>
