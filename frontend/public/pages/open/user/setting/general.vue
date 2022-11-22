<template>
  <div class="content-inner op-content-inner-with-header">
    <Portal to="page-title">General Settings</Portal>

    <BaseSettingSection title="Where You’re Logged in">
      <BaseSessionItemInSetting
        :session="{
          id: 1,
          isActive: true,
          ip: '127.0.0.1',
          browser: 'Chrome',
          device: 'IPhone',
          operatingSystem: 'IOS',
          city: 'Mariupol',
          country: 'Ukraine',
          coordinates: {
            latitude: 20.2323,
            longitude: 500.2323
          },
          lastActivity: '2020-08-23 13:23',
          countryCode: 'UA',
          region: 'Donechka',
          regionName: 'Donechka',
          timezone: 'GMT+3'
        }"
      />
      <BaseSessionItemInSetting
        :session="{
          id: 1,
          isActive: true,
          ip: '127.0.0.1',
          browser: 'Chrome',
          device: 'IPhone',
          operatingSystem: 'IOS',
          city: 'Mariupol',
          country: 'Ukraine',
          coordinates: {
            latitude: 20.2323,
            longitude: 500.2323
          },
          lastActivity: '2020-08-23 13:23',
          countryCode: 'UA',
          region: 'Donechka',
          regionName: 'Donechka',
          timezone: 'GMT+3'
        }"
      />
    </BaseSettingSection>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseSettingSection from '~/components/Business/Section/BaseSettingSection.vue';
import BaseSessionItemInSetting from '~/components/Business/Session/BaseSessionItemInSetting.vue';

@Component({
  layout: 'OPAccountSettingLayout',
  components: {
    BaseSettingSection,
    BaseSessionItemInSetting
  }
})
export default class General extends Vue {}
</script>

<style lang="scss"></style>
