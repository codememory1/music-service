<template>
  <div>
    <input type="text" @input="change" />
  </div>
</template>

<script lang="ts">
import { Component } from 'vue-property-decorator';
import TestComponent from '~/components/Business/TestComponent.vue';

@Component
export default class BlueComponent extends TestComponent {
  private change(event: InputEvent): void {
    this.setTitle(event.data as string);
  }
}
</script>
