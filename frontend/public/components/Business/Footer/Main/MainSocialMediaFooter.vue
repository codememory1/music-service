<template>
  <div class="main-footer__social-media">
    <a :href="link" class="main-footer__social-media-link">
      <i :class="faIcon" />
    </a>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class MainSocialMediaFooter extends Vue {
  @Prop({ required: true })
  private readonly link!: string | undefined;

  @Prop({ required: true })
  private readonly faIcon!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/footer/main/main-socail-media-footer.scss';
</style>
