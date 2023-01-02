import { NuxtApp } from '@nuxt/types/app';
import { AppType } from '~/types/AppType';
const { v4: uuidv4 } = require('uuid');

export default function (context: NuxtApp & AppType, inject: (key: string, value: any) => void) {
  context.$uuid = uuidv4();

  inject('uuid', context.$uuid);
}
