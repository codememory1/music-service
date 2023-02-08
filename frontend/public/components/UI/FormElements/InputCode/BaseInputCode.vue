<template>
  <div class="input-code-squares">
    <input
      v-for="(square, index) in inputCodeService.getSquares()"
      :key="index"
      ref="square"
      name="one-time-code"
      type="text"
      class="input-code__square"
      :class="{ error: square.isError() }"
      maxlength="1"
      autocomplete="off"
      @input="square.input($event.target, index)"
      @keydown="keydown($event)"
    />
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import InputCodeService from '~/services/ui/input-code/input-code-service';
import InputCodeKeydownService from '~/services/ui/input-code/input-code-keydown-service';

@Component
export default class BaseInputCode extends Vue {
  @Prop({ required: true })
  private readonly numberSquares!: number;

  @Prop({ required: false, default: 0 })
  private readonly activeSquareIndex!: number | null;

  @Prop({ required: false, default: '.*' })
  private readonly patternValue!: string;

  public inputCodeService!: InputCodeService;

  public created(): void {
    this.inputCodeService = new InputCodeService(this, this.numberSquares);
  }

  private mounted(): void {
    const squares = this.$refs.square as Array<HTMLInputElement>;

    this.inputCodeService.getSquares().forEach((square, index) => {
      square.setElement(squares[index]);
      square.setPatternValue(this.patternValue);
    });

    if (this.activeSquareIndex !== null) {
      this.inputCodeService.activeSquare(this.activeSquareIndex);
    }
  }

  private keydown(event: KeyboardEvent): void {
    new InputCodeKeydownService(this.inputCodeService).handle(event);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form-elements/input-code/base-input-code.scss';
</style>
