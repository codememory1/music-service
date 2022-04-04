<template>
  <div class="authors flex">
    <span v-for="author in authors" class="author" :key="author.id">
      <a class="author__link" href="">{{ author.name }}</a>
      <span class="author__separator">&</span>
    </span>
  </div>
</template>

<script>
import {
  arrayValidator,
  objectValidator
} from "~/node_modules/vue-props-validation/src";

export default {
  name: "BaseAuthors",
  props: {
    authors: {
      type: Array,
      validator: arrayValidator({
        type: Object,
        validator: objectValidator({
          id: Number,
          name: String
        })
      }),
      required: true
    }
  }
};
</script>
<style lang="sass">
@import "../../assets/css/components/authors/base-authors"
</style>
