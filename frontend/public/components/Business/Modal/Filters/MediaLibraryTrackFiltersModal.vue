<template>
  <FiltersModal ref="modal">
    <FilterItem :title="$t('filter_names.artist')">
      <BaseSelect :placeholder="$t('placeholder.select_artist')" :options="[]" />
      <!--FIX: Вставить всех артистов, которые в медиатеке-->
    </FilterItem>
    <FilterItem :title="$t('filter_names.album')">
      <BaseSelect :placeholder="$t('placeholder.select_album')" :options="[]" />
      <!--FIX: Вставить все альбомы, которые существуют в медиатеке-->
    </FilterItem>
  </FiltersModal>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import FiltersModal from '~/components/Business/Modal/FiltersModal.vue';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import FilterItem from '~/components/Business/Item/FilterItem.vue';
import BaseSelect from '~/components/UI/FormElements/Select/BaseSelect.vue';

@Component({
  components: {
    FiltersModal,
    FilterItem,
    BaseSelect
  }
})
export default class MediaLibraryTrackFiltersModal extends Vue {
  public open(): void {
    ((this.$refs.modal as FiltersModal).$refs.modal as BaseModal).open();
  }
}
</script>
