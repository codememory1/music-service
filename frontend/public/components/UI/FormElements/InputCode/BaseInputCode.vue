<template>
  <div class="input-code-squares">
    <input
      v-for="n in countSquares"
      :key="n"
      ref="inputCodeSquare"
      type="text"
      class="input-code__square"
      :class="{ error: isErrorSquare(n - 1) }"
      maxlength="1"
      @input="input($event, n - 1)"
      @keydown="keydown($event, n - 1)"
    />
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

type InputCodeType = {
  index: number;
  error: boolean;
};

@Component
export default class BaseInputCode extends Vue {
  @Prop({ required: true })
  private readonly countSquares!: number;

  @Prop({ required: false, default: null })
  private readonly activeSquareNumber!: number | null;

  public squares: Array<HTMLInputElement> = [];
  public codes: Array<string> = [];
  private squaresInfo: Array<InputCodeType> = [];

  private mounted(): void {
    this.squares = this.$refs.inputCodeSquare as Array<HTMLInputElement>;
    this.codes = this.squares.map((v, i) => {
      this.squaresInfo.push({
        index: i,
        error: false
      });

      return '';
    });

    if (this.activeSquareNumber !== null) {
      this.squares[this.activeSquareNumber - 1].focus();
    }
  }

  private input(event: InputEvent, i: number): void {
    if (i + 1 <= this.squares.length) {
      if (event.data !== null) {
        if (i + 1 < this.squares.length) {
          this.squares[i].blur();
          this.squares[i + 1].focus();
        }
        this.removeErrorSquare(i);
        this.codes[i] = event.data.toString();
      } else {
        this.codes[i] = '';
      }
    }

    this.$emit('change', event, this.codes, this.squares);
  }

  private keydown(event: KeyboardEvent, i: number): void {
    if (event.key === 'ArrowLeft') {
      if (i <= this.countSquares - 1 && i - 1 >= 0) {
        this.squares[i].blur();
        setTimeout(() => {
          const input = this.squares[i - 1];
          input.selectionStart = 1;
          input.focus();
        }, 0);
      }
    } else if (event.key === 'ArrowRight') {
      if (i + 1 <= this.countSquares - 1) {
        this.squares[i].blur();
        setTimeout(() => {
          const input = this.squares[i + 1];
          input.selectionStart = 1;
          input.focus();
        }, 0);
      }
    }
  }

  public isErrorSquare(index: number): boolean {
    let isError: boolean = false;

    this.squaresInfo.forEach((code: InputCodeType) => {
      if (code.index === index) {
        isError = code.error;
      }
    });

    return isError;
  }

  public setErrorSquare(index: number): void {
    this.squaresInfo.map((code: InputCodeType) => {
      if (code.index === index) {
        code.error = true;
      }

      return code;
    });
  }

  public removeErrorSquare(index: number): void {
    this.squaresInfo.map((code: InputCodeType) => {
      if (code.index === index) {
        code.error = false;
      }

      return code;
    });
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form-elements/input-code/base-input-code.scss';
</style>
