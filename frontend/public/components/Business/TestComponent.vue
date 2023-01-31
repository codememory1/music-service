<template>
  <h1>{{ title }}</h1>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class TestComponent extends Vue {
  private title: string = '';

  protected setTitle(title: string): void {
    this.title = title;
  }
}
</script>
