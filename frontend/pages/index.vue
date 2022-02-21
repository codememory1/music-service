<template>
  <div>
    <base-mobile-player title="Music name" image="/images/track1.png" :authors="[
      {id: 1, name: 'Danil'}
    ]"/>
  </div>
</template>

<script>
import BaseButton from "@/components/Buttons/BaseButton";
import BaseSubscription from "@/components/Subscriptions/BaseSubscription";
import BaseTrack from "@/components/Tracks/BaseTrack";
import BaseAlbum from "@/components/Albums/BaseAlbum";
import SingleAlbum from "@/components/Albums/SingleAlbum";
import BaseMobilePlayer from "@/components/Players/BaseMobilePlayer";
import isEmpty from "assets/js/helpers/is-empty";

export default {
  name: "IndexPage",
  components: {
    BaseButton,
    BaseSubscription,
    BaseTrack,
    BaseAlbum,
    SingleAlbum,
    BaseMobilePlayer,
  },
  data: () => ({
    data: []
  }),
  methods: {
    isEmpty,

    click() {
      this.data.push({ id: 1, name: "Danil kostyn" });
    },
    clickOut(e) {
      console.log(this.isEmpty(""));
    }
  }
};
</script>
