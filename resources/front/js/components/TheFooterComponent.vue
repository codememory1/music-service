<template>
  <footer class="footer" role="contentinfo">
    <div class="container">
      <img-alias class="footer__logo" alias="logo" alt="Logo" />

      <!-- Columns START -->
      <div class="footer-columns">
        <div class="footer-column">
          <span class="footer-column__name">About</span>
          <div class="footer-column-items">
            <a href="#">About</a>
            <a href="#">Submit an issue</a>
            <a href="#">GidHub Repo</a>
            <a href="#">Slack</a>
          </div>
        </div>
        <div class="footer-column">
          <span class="footer-column__name">Getting started</span>
          <div class="footer-column-items">
            <a href="#">Introduction</a>
            <a href="#">Documentation</a>
            <a href="#">Usage</a>
            <a href="#">Globals</a>
            <a href="#">Elements</a>
            <a href="#">Collections</a>
            <a href="#">Themes</a>
          </div>
        </div>
        <div class="footer-column">
          <span class="footer-column__name">Resources</span>
          <div class="footer-column-items">
            <a href="#">API</a>
            <a href="#">Form validation product</a>
            <a href="#">Visibility</a>
            <a href="#">Accessibility</a>
            <a href="#">Community</a>
            <a href="#">Design Defined</a>
            <a href="#">Marketplace</a>
          </div>
        </div>
        <div class="footer-column network">
          <span class="footer-column__name">Social media</span>
          <p>
            Follow us to social media to find out the latest updates on our
            progress
          </p>
          <div class="networks">
            <a href="#">
              <svg-alias alias="instagram-sq-svg" />
            </a>
            <a href="#">
              <svg-alias alias="facebook-sq-svg" />
            </a>
            <a href="#">
              <svg-alias alias="vk-sq-svg" />
            </a>
            <a href="#">
              <svg-alias alias="twitter-sq-svg" />
            </a>
          </div>
        </div>
      </div>
      <!-- Copyright END -->

      <!-- Copyright START -->
      <div class="copyright">
        <span>© 2021 flow-ui. All rights reserved</span>
        <div class="copyright-items">
          <a href="#">Teams of Service</a>
          <a href="#">Privacy Policy</a>
          <a href="#">Security</a>
          <a href="#">Sitemap</a>
        </div>
      </div>
      <!-- Copyright END -->
    </div>
  </footer>
</template>
<script>
export default {
  name: "TheFooterComponent"
};
</script>
<style lang="scss">
@import "../../scss/components/footer";
</style>
