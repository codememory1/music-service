<template>
  <footer class="footer">
    <div class="container">
      <div class="footer__logo">
        <img-alias alias="logo" alt="logo" />
      </div>
      <div class="footer__columns">
        <div class="footer__column">
          <div class="footer_column__name">About</div>
          <div class="footer_column__items">
            <a href="#">About</a>
            <a href="#">Submit an issue</a>
            <a href="#">GidHub Repo</a>
            <a href="#">Slack</a>
          </div>
        </div>
        <div class="footer__column">
          <div class="footer_column__name">Getting started</div>
          <div class="footer_column__items">
            <a href="#">Introduction</a>
            <a href="#">Documentation</a>
            <a href="#">Usage</a>
            <a href="#">Globals</a>
            <a href="#">Elements</a>
            <a href="#">Collections</a>
            <a href="#">Themes</a>
          </div>
        </div>
        <div class="footer__column">
          <div class="footer_column__name">Resources</div>
          <div class="footer_column__items">
            <a href="#">API</a>
            <a href="#">Form validation product</a>
            <a href="#">Visibility</a>
            <a href="#">Accessibility</a>
            <a href="#">Community</a>
            <a href="#">Design Defined</a>
            <a href="#">Marketplace</a>
          </div>
        </div>
        <div class="footer__column footer__column--network">
          <div class="footer_column__name">Social media</div>
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
      <div class="copyright">
        <span>© 2021 flow-ui. All rights reserved</span>
        <div class="copyright__items">
          <a href="#">Teams of Service</a>
          <a href="#">Privacy Policy</a>
          <a href="#">Security</a>
          <a href="#">Sitemap</a>
        </div>
      </div>
    </div>
  </footer>
</template>
<script>
export default {
  name: "TheFooter"
};
</script>
<style lang="scss">
@import "../../scss/components/footer";
</style>
