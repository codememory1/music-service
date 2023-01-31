<template>
  <footer class="wp-footer">
    <div class="wp-container">
      <MainContentFooter />
    </div>
  </footer>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import MainContentFooter from '~/components/Business/Footer/Main/MainContentFooter.vue';

@Component({
  components: {
    MainContentFooter
  }
})
export default class TheWebPlayerFooter extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/footer/the-wp-footer.scss';
</style>
