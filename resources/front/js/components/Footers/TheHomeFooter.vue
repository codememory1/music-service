<template>
  <footer class="footer">
    <div class="container">
      <img-alias class="footer__logo" alias="logo" :alt="$env.APP_NAME" />

      <!-- Columns START -->
      <div class="footer-columns">
        <the-home-footer-column label="About">
          <the-home-footer-column-item link="#">
            About
          </the-home-footer-column-item>
          <the-home-footer-column-item link="#">
            Submit an issue
          </the-home-footer-column-item>
          <the-home-footer-column-item link="#">
            GitHub Repo
          </the-home-footer-column-item>
          <the-home-footer-column-item link="#">
            Slack
          </the-home-footer-column-item>
        </the-home-footer-column>
        <the-home-footer-column label="Getting started">
          <the-home-footer-column-item link="#">
            Introduction
          </the-home-footer-column-item>
          <the-home-footer-column-item link="#">
            Documentation
          </the-home-footer-column-item>
          <the-home-footer-column-item link="#">
            Usage
          </the-home-footer-column-item>
          <the-home-footer-column-item link="#">
            Globals
          </the-home-footer-column-item>
          <the-home-footer-column-item link="#">
            Elements
          </the-home-footer-column-item>
          <the-home-footer-column-item link="#">
            Collections
          </the-home-footer-column-item>
          <the-home-footer-column-item link="#">
            Themes
          </the-home-footer-column-item>
        </the-home-footer-column>
        <the-home-footer-column label="Resources">
          <the-home-footer-column-item link="#">
            API
          </the-home-footer-column-item>
          <the-home-footer-column-item link="#">
            Form validation product
          </the-home-footer-column-item>
          <the-home-footer-column-item link="#">
            Visibility
          </the-home-footer-column-item>
          <the-home-footer-column-item link="#">
            Accessibility
          </the-home-footer-column-item>
          <the-home-footer-column-item link="#">
            Community
          </the-home-footer-column-item>
          <the-home-footer-column-item link="#">
            Design Defined
          </the-home-footer-column-item>
          <the-home-footer-column-item link="#">
            Marketplace
          </the-home-footer-column-item>
        </the-home-footer-column>
        <the-home-footer-column
          class="network"
          label="Social media"
          :custom-content="true"
        >
          <p>
            Follow us to social media to find out the latest updates on our
            progress
          </p>
          <the-home-footer-networks />
        </the-home-footer-column>
      </div>
      <!-- Columns END -->

      <the-home-footer-copyright />
    </div>
  </footer>
</template>

<script>
import TheHomeFooterColumn from "./TheHomeFooterColumn";
import TheHomeFooterColumnItem from "./TheHomeFooterColumnItem";
import TheHomeFooterNetworks from "./TheHomeFooterNetworks";
import TheHomeFooterCopyright from "./TheHomeFooterCopyright";

export default {
  name: "TheHomeFooter",
  components: {
    TheHomeFooterColumn,
    TheHomeFooterColumnItem,
    TheHomeFooterNetworks,
    TheHomeFooterCopyright
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/footers/the-home-footer";
</style>
