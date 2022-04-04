import {
  arrayValidator,
  objectValidator
} from "~/node_modules/vue-props-validation/src";

export const authors = {
  type: Array,
  validator: arrayValidator({
    type: Object,
    validator: objectValidator({
      id: Number,
      name: String
    })
  }),
  required: true
};
