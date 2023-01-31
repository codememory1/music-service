<template>
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
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import TheVerticalNavigation from '~/components/Business/Navigation/Vertical/TheVerticalNavigation.vue';
import GroupVerticalNavigation from '~/components/Business/Navigation/Vertical/GroupVerticalNavigation.vue';
import ItemVerticalNavigation from '~/components/Business/Navigation/Vertical/ItemVerticalNavigation.vue';
import AuthorizedUserService from '~/services/business/user/authorized-user-service';

@Component({
  components: {
    TheVerticalNavigation,
    GroupVerticalNavigation,
    ItemVerticalNavigation
  }
})
export default class WebPlayerVerticalNavigation extends Vue {
  private readonly authorizedUserService: AuthorizedUserService = new AuthorizedUserService(this);
}
</script>
