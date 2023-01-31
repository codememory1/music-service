<template>
  <div class="wp-layout">
    <TheVerticalNavigation>
      <GroupVerticalNavigation>
        <ItemVerticalNavigation link="/web-player">
          <i class="fal fa-home" /> {{ $t('web_player.navigation.home') }}
        </ItemVerticalNavigation>
        <ItemVerticalNavigation link="/web-player/search">
          <i class="fal fa-search" /> {{ $t('web_player.navigation.search') }}
        </ItemVerticalNavigation>
        <ItemVerticalNavigation link="/web-player/search">
          <i class="fal fa-user-music" /> {{ $t('web_player.navigation.popular_artists') }}
        </ItemVerticalNavigation>
        <ItemVerticalNavigation link="/web-player/mix">
          <i class="fab fa-mixcloud" /> {{ $t('web_player.navigation.mix') }}
        </ItemVerticalNavigation>
      </GroupVerticalNavigation>
      <GroupVerticalNavigation
        v-show="authorizedUserService.getAuthorizedUser() !== null"
        :title="$t('web_player.navigation_groups.my_library')"
      >
        <ItemVerticalNavigation link="/web-player/history">
          <i class="fal fa-history" /> {{ $t('web_player.navigation.history') }}
        </ItemVerticalNavigation>
        <ItemVerticalNavigation link="/web-player/media-library">
          <i class="fal fa-book-heart" /> {{ $t('web_player.navigation.media_library') }}
        </ItemVerticalNavigation>
        <ItemVerticalNavigation link="/web-player/friends">
          <i class="fal fa-user-friends" /> {{ $t('web_player.navigation.friends') }}
        </ItemVerticalNavigation>
        <ItemVerticalNavigation link="/web-player/favorite-artists">
          <i class="fal fa-heart" /> {{ $t('web_player.navigation.favorite_artists') }}
        </ItemVerticalNavigation>
        <ItemVerticalNavigation link="/web-player/playlists">
          <i class="fal fa-list-music" /> {{ $t('web_player.navigation.playlists') }}
        </ItemVerticalNavigation>
        <ItemVerticalNavigation link="/web-player/my-best-musics">
          <i class="fal fa-user-music" /> {{ $t('web_player.navigation.my_best_musics') }}
        </ItemVerticalNavigation>
      </GroupVerticalNavigation>
    </TheVerticalNavigation>
    <div class="wp-main-wrapper">
      <div
        ref="content"
        class="wp-main-page"
        :class="{ 'scroll-allowed': contentScrollingAllowed }"
        @scroll="scrollContent"
      >
        <TheWebPlayerHeader :active="headerIsActive">
          <TheSearchWebPlayerHeader />
        </TheWebPlayerHeader>
        <div class="wp-main-content">
          <Nuxt />
        </div>
        <TheWebPlayerFooter />
      </div>
      <BasePlayer />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import TheVerticalNavigation from '~/components/Business/Navigation/Vertical/TheVerticalNavigation.vue';
import GroupVerticalNavigation from '~/components/Business/Navigation/Vertical/GroupVerticalNavigation.vue';
import ItemVerticalNavigation from '~/components/Business/Navigation/Vertical/ItemVerticalNavigation.vue';
import TheWebPlayerHeader from '~/components/Business/Header/TheWebPlayerHeader.vue';
import TheSearchWebPlayerHeader from '~/components/Business/Header/TheSearchWebPlayerHeader.vue';
import BasePlayer from '~/components/Business/Player/BasePlayer.vue';
import AuthorizedUserService from '~/services/business/user/authorized-user-service';
import TheWebPlayerFooter from '~/components/Business/Footer/TheWebPlayerFooter.vue';

@Component({
  components: {
    TheVerticalNavigation,
    GroupVerticalNavigation,
    ItemVerticalNavigation,
    TheWebPlayerHeader,
    TheSearchWebPlayerHeader,
    BasePlayer,
    TheWebPlayerFooter
  }
})
export default class WebPlayerLayout extends Vue {
  private readonly authorizedUserService: AuthorizedUserService = new AuthorizedUserService(this);
  private headerIsActive: boolean = false;

  public mounted(): void {
    this.headerIsActive = (this.$refs.content as HTMLElement).scrollTop >= 40;
  }

  private scrollContent(event: Event): void {
    this.headerIsActive = (event.target as HTMLElement).scrollTop >= 40;
  }

  private get contentScrollingAllowed(): boolean {
    return this.$store.getters['modules/global-module/contentScrollingAllowed'];
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/layouts/web-player-layout.scss';
</style>