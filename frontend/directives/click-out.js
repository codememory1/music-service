import Vue from "vue";

Vue.directive("click-out", {
  inserted: (el, binding) => {
    document.addEventListener("click", (e) => {
      if (!e.composedPath().includes(el)) {
        binding.value();
      }
    });
  }
});
