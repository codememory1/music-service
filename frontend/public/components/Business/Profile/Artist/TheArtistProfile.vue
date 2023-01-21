<template>
  <div class="artist-profile" :style="styles">
    <div class="wp-container wp-pt-of-header artist-profile-content">
      <div class="artist-profile-info">
        <h1 class="artist-profile__name">{{ name }}</h1>
        <p class="artist-profile__description">{{ description }}</p>
      </div>

      <div class="artist-profile-buttons">
        <div class="artist-profile-buttons-left">
          <BaseButton class="accent artist-profile__sub-btn">
            {{ $t('artist.buttons.subscribe') }}
          </BaseButton>
          <BaseButton class="dark artist-profile__sub-btn">
            {{ $t('artist.buttons.unsubscribe') }}
          </BaseButton>
        </div>
        <div class="artist-profile-buttons-right">
          <BaseButton class="blue artist-profile__share-btn">
            <i class="fal fa-share" />
          </BaseButton>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class TheArtistProfile extends Vue {
  @Prop({ required: true })
  private readonly name!: string;

  @Prop({ required: false, default: null })
  private readonly description!: string | null;

  @Prop({ required: false, default: null })
  private readonly background!: string;

  private get styles(): object {
    return {
      'background-image': `url("${this.background}")`
    };
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/profile/artist/artist-profile.scss';
</style>
