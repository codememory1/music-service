<template>
  <base-button class="bg--accent" @click="$emit('click', $event)">
    Subscribe
  </base-button>
</template>

<script>
import BaseButton from "@/components/Buttons/BaseButton";

export default {
  name: "SubscribeButton",
  components: {
    BaseButton
  }
}
</script>
