<template>
  <span class="selected__tag">
    {{ label }}
    <i @click="$emit('click', $event)" class="fal fa-times"></i>
  </span>
</template>

<script>
export default {
  name: "BaseSelectTagComponent",
  props: {
    /**
     * @type {String}
     */
    label: {
      type: String,
      required: true
    }
  }
};
</script>
