import { NuxtApp } from '@nuxt/types/app';
const { v4: uuidv4 } = require('uuid');

export default function (context: NuxtApp, inject: (key: string, value: any) => void) {
  context.$uuid = uuidv4();

  inject('uuid', context.$uuid);
}
