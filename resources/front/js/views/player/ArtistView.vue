<template>
  <div ref="mainContent" class="main__content">
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
    <section-albums sectionTitle="Top Albums" :albums="bestTracks">
      <template v-slot:slider="{ album }">
        <base-album
          :name="album.name"
          :image="album.image"
          :authors="album.authors"
          :to="album.to"
        />
      </template>
    </section-albums>
    <!-- Top albums END -->

    <div class="columns">
      <!-- Top musics START -->
      <base-section title="Top tracks" class="section-top-musics">
        <template v-slot:content>
          <music-item
            name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
          <music-item
            name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
          <music-item
            name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
          <music-item
            name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
          <music-item
            name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
          <music-item
            name="NO MERCY"
            image="/public/images/track1.png"
            author="Tvbuu"
            @contextmenu="musicItemContextMenu"
          />
        </template>
      </base-section>
      <!-- Top musics END -->

      <!-- Similar artists START -->
      <base-section title="Similar artists" class="section-similar-artists">
        <template v-slot:content>
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
            <template v-slot:content>
              <album-with-play
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
    <drop-down
      ref="musicItemDropDown"
      class="music-item-drop-down"
      :is-active="
        isOpenedMusicItemDropDown && !$store.getters['layoutScroll/isScroll']
      "
      :style="musicItemDropDownStyle()"
    >
      <drop-down-item label="Добавить в медиатеку" />
      <drop-down-item label="Добавить в плейлист" />
      <drop-down-border />
      <drop-down-item label="Воспроизвести далее" />
      <drop-down-item label="В конец очереди" />
      <drop-down-border />
      <drop-down-item label="Поделиться песней" />
      <drop-down-item label="Поделиться текстом" />
      <drop-down-border />
      <drop-down-item label="Открыть полный текст песни" />
      <drop-down-border />
      <drop-down-item label="Показать альбом" />
      <drop-down-item label="Нравится" />
      <drop-down-item label="Не нравится" />
    </drop-down>
  </div>
</template>
<script>
import { mapMutations, mapGetters } from "vuex";
import BaseButton from "../../components/Buttons/BaseButtonComponent";
import ShareButton from "../../components/Buttons/ShareButtonComponent";
import BaseAlbum from "../../components/Albums/BaseAlbumComponent";
import SectionAlbums from "../../components/SectionAlbumsComponent";
import BaseSection from "../../components/Sections/BaseSectionComponent";
import MusicItem from "../../components/MusicItemComponent";
import AlbumWithPlay from "../../components/Albums/AlbumWithPlayComponent";
import DropDown from "../../components/DropDown/DropDownComponent";
import DropDownItem from "../../components/DropDown/DropDownItemComponent";
import DropDownBorder from "../../components/DropDown/DropDownBorderComponent";
import ClickOut from "../../modules/ClickOut";

export default {
  name: "ArtistView",
  components: {
    BaseButton,
    ShareButton,
    BaseAlbum,
    SectionAlbums,
    BaseSection,
    MusicItem,
    AlbumWithPlay,
    DropDown,
    DropDownItem,
    DropDownBorder
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

  created() {
    this.$store.commit("loading/setLoading", false);
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
<style lang="scss" scoped>
@import "../../../scss/views/artist";

.music-item-drop-down {
  visibility: hidden;
  opacity: 0;
  transform: translateY(80px);
  transition: visibility 0.2s ease-in-out, opacity 0.2s ease-in-out,
    transform 0.5s ease-in-out;

  &.active {
    visibility: visible;
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
