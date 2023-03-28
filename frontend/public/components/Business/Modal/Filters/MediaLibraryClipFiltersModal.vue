<template>
  <FiltersModal ref="modal">
    <FilterItem title="Artist">
      <BaseSelect :placeholder="$t('placeholder.select_artist')" :options="[]" />
      <!--FIX: Вставить всех артистов, которые в медиатеке-->
    </FilterItem>
    <FilterItem title="Album">
      <BaseSelect :placeholder="$t('placeholder.select_album')" :options="[]" />
      <!--FIX: Вставить все альбомы, которые существуют в медиатеке-->
    </FilterItem>
  </FiltersModal>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import FiltersModal from '~/components/Business/Modal/FiltersModal.vue';
import FilterItem from '~/components/Business/Item/FilterItem.vue';
import BaseSelect from '~/components/UI/FormElements/Select/BaseSelect.vue';

@Component({
  components: {
    FiltersModal,
    FilterItem,
    BaseSelect
  }
})
export default class MediaLibraryClipFiltersModal extends Vue {
  public open(): void {
    ((this.$refs.modal as FiltersModal).$refs.modal as BaseModal).open();
  }
}
</script>
