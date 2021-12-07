<template>
  <span class="base-button c-pointer" @click="$emit('click')">
    <slot />
  </span>
</template>
<script>
export default {
  name: "BaseCustomClickButton"
};
</script>
