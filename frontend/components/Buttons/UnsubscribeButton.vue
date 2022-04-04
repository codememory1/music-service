<template>
  <base-button class="bg--dark" @click="$emit('click', $event)">
    Unsubscribe
  </base-button>
</template>

<script>
import BaseButton from "@/components/Buttons/BaseButton";

export default {
  name: "UnsubscribeButton",
  components: {
    BaseButton
  }
}
</script>
