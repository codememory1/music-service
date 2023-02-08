<template>
  <footer class="main-footer">
    <div class="container">
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
export default class TheMainFooter extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/footer/main/the-main-footer.scss';
</style>
