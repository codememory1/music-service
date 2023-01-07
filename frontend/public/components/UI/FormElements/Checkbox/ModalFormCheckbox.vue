<template>
  <div class="modal-form-checkbox">
    <BaseCheckbox v-model="isAccept" :is-error="isError" />
    <p class="modal-form-checkbox__description" v-html="description" />
  </div>
</template>

<script lang="ts">
import { Component, Prop, VModel, Vue } from 'vue-property-decorator';
import BaseCheckbox from '~/components/UI/FormElements/Checkbox/BaseCheckbox.vue';

@Component({
  components: {
    BaseCheckbox
  }
})
export default class ModalFormCheckbox extends Vue {
  @Prop({ required: true })
  private readonly description!: string;

  @Prop({ required: false, default: false })
  private readonly isError!: boolean;

  @VModel({ required: false, default: false })
  private readonly isAccept!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form-elements/checkbox/modal-form-checkbox.scss';
</style>
