<template>
  <div>
<!--    <base-drop-down>-->
<!--      <base-drop-down-items>-->
<!--        <base-drop-down-item>Add to queue</base-drop-down-item>-->
<!--        <base-drop-down-item>Go to playlist radio</base-drop-down-item>-->
<!--        <base-drop-down-separator />-->
<!--        <base-drop-down-item>Collaborative playlist</base-drop-down-item>-->
<!--        <base-drop-down-item>Remove from playlist</base-drop-down-item>-->
<!--        <base-drop-down-separator />-->
<!--        <base-drop-down-item>Edit details</base-drop-down-item>-->
<!--        <base-drop-down-item :disabled="true">-->
<!--          Create similar playlist-->
<!--        </base-drop-down-item>-->
<!--        <base-drop-down-item>Delete</base-drop-down-item>-->
<!--        <base-drop-down-item>Rename</base-drop-down-item>-->
<!--        <base-drop-down-separator />-->
<!--        <base-drop-down-item :disabled="true">Download</base-drop-down-item>-->
<!--        <base-drop-down-item>Create playlist</base-drop-down-item>-->
<!--        <base-drop-down-item>Create folder</base-drop-down-item>-->
<!--        <base-drop-down-separator />-->
<!--        <base-drop-down-item :multiple="true" :to-window="1" :to-back="0">-->
<!--          Share-->
<!--          <template #drop-down>-->
<!--            <base-drop-down-items>-->
<!--              <base-drop-down-item>Instargam</base-drop-down-item>-->
<!--              <base-drop-down-item>Google</base-drop-down-item>-->
<!--            </base-drop-down-items>-->
<!--          </template>-->
<!--        </base-drop-down-item>-->
<!--      </base-drop-down-items>-->
<!--    </base-drop-down>-->
    <base-desktop-player/>
  </div>
</template>

<script>
import BaseButton from "@/components/Buttons/BaseButton";
import BaseSubscription from "@/components/Subscriptions/BaseSubscription";
import BaseTrack from "@/components/Tracks/BaseTrack";
import BaseAlbum from "@/components/Albums/BaseAlbum";
import SingleAlbum from "@/components/Albums/SingleAlbum";
import BaseMobilePlayer from "@/components/Players/BaseMobilePlayer";
import BaseDropDown from "@/components/DropDown/BaseDropDown";
import BaseDropDownItem from "@/components/DropDown/BaseDropDownItem";
import BaseDropDownItems from "@/components/DropDown/BaseDropDownItems";
import BaseDropDownSeparator from "@/components/DropDown/BaseDropDownSeparator";
import isEmpty from "assets/js/helpers/is-empty";
import BaseDesktopPlayer from "@/components/Players/BaseDesktopPlayer";

export default {
  name: "IndexPage",
  components: {
    BaseButton,
    BaseSubscription,
    BaseTrack,
    BaseAlbum,
    SingleAlbum,
    BaseMobilePlayer,
    BaseDropDown,
    BaseDropDownItem,
    BaseDropDownItems,
    BaseDropDownSeparator,
    BaseAlbum,
    SingleAlbum,
    BaseDesktopPlayer
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
