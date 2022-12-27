<template>
  <div class="accept-terms">
    <BaseCheckbox v-model="isAccept" :is-error="isError" />
    <p class="accept-terms__description" v-html="description" />
  </div>
</template>

<script lang="ts">
import { Component, Prop, VModel, Vue } from 'vue-property-decorator';
import BaseCheckbox from '~/components/UI/Checkbox/BaseCheckbox.vue';

@Component({
  components: {
    BaseCheckbox
  }
})
export default class AcceptTerms extends Vue {
  @Prop({ required: true })
  private readonly description!: string;

  @Prop({ required: false, default: false })
  private readonly isError!: boolean;

  @VModel({ required: false, default: false })
  private readonly isAccept!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/form-element/accept-terms.scss';
</style>
