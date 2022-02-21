<template>
  <base-button class="bg--blue" @click="$emit('click', $event)">
    <svg-alias alias="share"/>
  </base-button>
</template>

<script>
import BaseButton from "@/components/Buttons/BaseButton";

export default {
  name: "ShareButton",
  components: {
    BaseButton
  }
}
</script>
