<template>
  <nav class="main-navigation">
    <ul class="main-navigation-items">
      <li class="main-navigation__item">
        <NuxtLink to="" class="main-navigation__link active">Premium</NuxtLink>
      </li>
      <li class="main-navigation__item">
        <NuxtLink to="" class="main-navigation__link">Help</NuxtLink>
      </li>
      <li class="main-navigation__item">
        <NuxtLink to="" class="main-navigation__link">Donwload</NuxtLink>
      </li>
      <li class="main-navigation__item main-navigation__item-sign-up" @click="$emit('signUp')">
        <NuxtLink to="" class="main-navigation__link">Sign up</NuxtLink>
      </li>
      <li class="main-navigation__item" @click="$emit('signIn')">
        <NuxtLink to="" class="main-navigation__link">Sign in</NuxtLink>
      </li>
    </ul>
  </nav>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class MainNavigation extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/navigation/main-navigation';
</style>
