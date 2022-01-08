<template>
  <div class="header-content">
    <div class="header-content-left">
      <h1 class="header__heading">
        Listening is everything in your life
      </h1>
      <p class="header__sub-title">
        Millions of songs and podcasts. No credit card. of songs and podcasts.
        No credit card.
      </p>
      <base-link-button class="header-content__button bg--accent" link="#">
        Create account
      </base-link-button>
    </div>
    <div class="header-content-right">
      <img src="../../../../../public/images/mockup.png" alt="mockup" />
    </div>
  </div>
</template>

<script>
import BaseLinkButton from "../Buttons/BaseLinkButton";

export default {
  name: "TheHomeHeaderContent",
  components: {
    BaseLinkButton
  }
};
</script>

<style lang="scss" scoped>
@import "../../../scss/components/headers/the-home-header-content";
</style>
