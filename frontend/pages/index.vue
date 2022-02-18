<template>
  <div>
    <base-track title="Music Name" image="/images/track1.png" :authors="[{id: 1, name: 'Danil'}]"/>
  </div>
</template>

<script>
import BaseButton from "@/components/Buttons/BaseButton";
import BaseSubscription from "@/components/Subscriptions/BaseSubscription";
import BaseTrack from "@/components/Tracks/BaseTrack";

export default {
  name: "IndexPage",
  components: {
    BaseButton,
    BaseSubscription,
    BaseTrack
  }
}
</script>
