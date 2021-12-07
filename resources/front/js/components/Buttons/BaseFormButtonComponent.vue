<template>
  <button class="base-button c-pointer" @click="$emit('click')">
    <slot />
  </button>
</template>
<script>
export default {
  name: "BaseFormButton"
};
</script>
