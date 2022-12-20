<template>
  <section class="section">
    <slot name="header" />

    <div class="section-content">
      <slot />
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class BaseSection extends Vue {}
</script>
