<template>
  <div class="select-search-wrapper">
    <input
      type="text"
      class="select-search__input"
      placeholder="Search..."
      @input="$emit('input', $event)"
    />
    <svg-alias alias="search-svg" />
  </div>
</template>

<script>
export default {
  name: "BaseSelectSearch"
};
</script>

<style lang="scss">
@import "../../../scss/components/selects/base-select-search";
</style>
