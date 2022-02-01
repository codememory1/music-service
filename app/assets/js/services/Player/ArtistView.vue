<template>
  <main ref="mainContent" class="main-content" role="main">
    <!-- Header START -->
    <div class="artist-header" :style="artistHeaderStyle">
      <div class="relative">
        <h1 class="artist__name">{{ artistInfo.name }}</h1>
        <p class="artist__description">{{ artistInfo.description }}</p>
        <div class="artist-actions">
          <base-button
            v-if="artistInfo.isSubscribed"
            class="bg--accent btn-subscription"
          >
            Subscribe
          </base-button>
          <base-button v-else class="bg--dark btn-subscription">
            Unsubscribe
          </base-button>
          <share-button />
        </div>
      </div>
    </div>
    <!-- Header END -->

    <!-- Top albums START -->
    <albums-section title="Top Albums" :albums="bestTracks">
      <template v-slot:slider="{ album }">
        <base-album
          :name="album.name"
          :image="album.image"
          :authors="album.authors"
          :to="album.to"
        />
      </template>
    </albums-section>
    <!-- Top albums END -->

    <div class="columns">
      <!-- Top musics START -->
      <base-section title="Top tracks" class="section-top-musics">
        <template v-slot:content>
          <base-track
            track-name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
          <base-track
            track-name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
          <base-track
            track-name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
          <base-track
            track-name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
          <base-track
            track-name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
          <base-track
            track-name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
        </template>
      </base-section>
      <!-- Top musics END -->

      <!-- Similar artists START -->
      <base-section title="Similar artists" class="section-similar-artists">
        <template #content>
          <div class="similar-artists">
            <div
              v-for="(artist, index) in similarArtists"
              :key="index"
              class="similar-artist"
            >
              <router-link :to="{ name: 'artist', params: { id: artist.id } }">
                <img :src="artist.image" :alt="artist.name" />
              </router-link>
            </div>
          </div>

          <!-- Best albums of similar artists START -->
          <base-section
            title="Best albums of similar artists"
            class="best-albums-similar-artists"
          >
            <template #content>
              <album-with-play-button
                v-for="(bestAlbum, index) in bestAlbumsSimilarArtists"
                :key="index"
                :name="bestAlbum.name"
                :image="bestAlbum.image"
                :authors="bestAlbum.authors"
                :to="bestAlbum.to"
              />
            </template>
          </base-section>
          <!-- Best albums of similar artists END -->
        </template>
      </base-section>
      <!-- Similar artists END -->
    </div>
    <base-drop-down
      class="track-drop-down"
      ref="musicItemDropDown"
      :is-active="
        isOpenedMusicItemDropDown && !$store.getters['layoutScroll/isScroll']
      "
      :style="musicItemDropDownStyle()"
    >
      <base-drop-down-item label="Добавить в медиатеку" />
      <base-drop-down-item label="Добавить в плейлист" />
      <base-drop-down-separator />
      <base-drop-down-item label="Воспроизвести далее" />
      <base-drop-down-item label="В конец очереди" />
      <base-drop-down-separator />
      <base-drop-down-item label="Поделиться песней" />
      <base-drop-down-item label="Поделиться текстом" />
      <base-drop-down-separator />
      <base-drop-down-item label="Открыть полный текст песни" />
      <base-drop-down-separator />
      <base-drop-down-item label="Показать альбом" />
      <base-drop-down-item label="Нравится" />
      <base-drop-down-item label="Не нравится" />
    </base-drop-down>
  </main>
</template>
<script>
import { mapMutations, mapGetters } from "vuex";
import BaseButton from "../../components/Buttons/BaseButton";
import ShareButton from "../../components/Buttons/ShareButton";
import BaseAlbum from "../../components/Albums/BaseAlbum";
import AlbumsSection from "../../components/Sections/AlbumsSection";
import BaseSection from "../../components/Sections/BaseSection";
import BaseTrack from "../../components/Tracks/BaseTrack";
import AlbumWithPlayButton from "../../components/Albums/AlbumWithPlayButton";
import BaseDropDown from "../../components/ContextMenus/BaseDropDown";
import BaseDropDownItem from "../../components/ContextMenus/BaseDropDownItem";
import BaseDropDownSeparator from "../../components/ContextMenus/BaseDropDownSeparator";
import ClickOut from "../../modules/helpers/ClickOut.js";

export default {
  name: "ArtistView",
  components: {
    AlbumsSection,
    BaseButton,
    ShareButton,
    BaseAlbum,
    BaseSection,
    BaseTrack,
    AlbumWithPlayButton,
    BaseDropDown,
    BaseDropDownItem,
    BaseDropDownSeparator
  },

  data: () => ({
    artistInfo: {
      name: "Zara Larsson",
      description:
        "Millions of songs and podcasts. No credit card. of songs and podcasts. No credit card.",
      background: "/public/images/artist-header.png",
      isSubscribed: false
    },
    bestTracks: [
      {
        name: "NO MERCY",
        image: "/public/images/album-image.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image2.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image3.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image4.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image5.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image6.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      }
    ],
    similarArtists: [
      {
        id: 1,
        name: "Name",
        image: "/public/images/artist.png"
      },
      {
        id: 1,
        name: "Name",
        image: "/public/images/artist2.png"
      },
      {
        id: 1,
        name: "Name",
        image: "/public/images/artist3.png"
      },
      {
        id: 1,
        name: "Name",
        image: "/public/images/artist4.png"
      },
      {
        id: 1,
        name: "Name",
        image: "/public/images/artist5.png"
      },
      {
        id: 1,
        name: "Name",
        image: "/public/images/artist2.png"
      },
      {
        id: 1,
        name: "Name",
        image: "/public/images/artist.png"
      },
      {
        id: 1,
        name: "Name",
        image: "/public/images/artist.png"
      }
    ],
    bestAlbumsSimilarArtists: [
      {
        name: "NO MERCY",
        image: "/public/images/album-image.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image2.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      },
      {
        name: "NO MERCY",
        image: "/public/images/album-image2.png",
        to: "",
        authors: [
          {
            id: 1,
            name: "Tvbuu"
          }
        ]
      }
    ],
    isOpenedMusicItemDropDown: false,
    musicItemDropDownX: 0,
    musicItemDropDownY: 0
  }),

  computed: {
    ...mapGetters({
      contentX: "layoutScroll/getContentX",
      contentY: "layoutScroll/getContentY"
    }),

    artistHeaderStyle() {
      return {
        backgroundImage: `url(${this.artistInfo.background})`
      };
    }
  },

  mounted() {
    ClickOut(this.$refs.musicItemDropDown.$el, (status) => {
      if (status) {
        this.isOpenedMusicItemDropDown = false;
        this.setLayoutScroll(false);
      }
    });
  },

  methods: {
    ...mapMutations({
      setLayoutScroll: "layoutScroll/setScroll"
    }),

    musicItemDropDownStyle() {
      return {
        top: `${this.musicItemDropDownY}px`,
        left: `${this.musicItemDropDownX}px`
      };
    },

    musicItemContextMenu: function (event, isButton) {
      const musicItemDropDownRect =
        this.$refs.musicItemDropDown.$el.getBoundingClientRect();
      const dropDownPosition =
        event.clientY - this.contentY + musicItemDropDownRect.height;

      this.isOpenedMusicItemDropDown = false;
      this.setLayoutScroll(false);

      setTimeout(() => {
        this.isOpenedMusicItemDropDown = true;
        this.musicItemDropDownX = event.clientX - this.contentX;

        if (true === isButton) {
          this.musicItemDropDownX -= musicItemDropDownRect.width + 20;
        }

        if (dropDownPosition > window.innerHeight) {
          this.musicItemDropDownY =
            event.clientY - this.contentY - musicItemDropDownRect.height;
        } else {
          this.musicItemDropDownY = event.clientY - this.contentY;
        }
      }, 300);
    }
  }
};
</script>
<style lang="scss">
@import "../../../scss/views/artist";
</style>
