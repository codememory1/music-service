<template>
  <span class="select__selected-tag">
    {{ label }}
    <i @click="$emit('click', $event)" class="fal fa-times"></i>
  </span>
</template>

<script>
export default {
  name: "BaseSelectTag",
  props: {
    /**
     * Tag label
     */
    label: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/selects/base-select-tag";
</style>
