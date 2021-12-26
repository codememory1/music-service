<template>
  <base-header>
    <template v-slot:beforeProfile>
      <div class="player-header__search">
        <svg-alias alias="search-svg" />
        <input
          type="text"
          placeholder="Search"
          class="player-header__search-input"
        />
      </div>
    </template>
  </base-header>
</template>
<script>
import BaseHeader from "./BaseHeaderComponent";

export default {
  name: "ThePlayerHeader",
  components: {
    BaseHeader
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/variables";

.player-header__search {
  position: relative;
  display: flex;
  align-items: center;

  svg {
    width: 20px;
    height: 20px;
    margin-right: 8px;
    position: relative;

    ::v-deep path {
      fill: #fff;
      transition: fill 0.3s ease-in-out;
    }
  }

  &-input {
    background-color: transparent;
    border: none;
    outline: none;
    color: #fff;
    font-size: 14px;
    font-weight: 500;

    ::placeholder {
      color: darken(#fff, 10%);
    }
  }
}
</style>
