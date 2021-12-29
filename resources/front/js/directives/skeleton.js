export default {
  bind: function (el, binding) {
    if (binding.arg === "status" && binding.value) {
      el.classList.add("skeleton-active");
    }

    if (binding.arg === "width") {
      el.style.width = binding.value;
    }
  },

  componentUpdated: function (el, binding) {
    console.log(binding)
    if (binding.arg === "status" && binding.value) {
      el.classList.add("skeleton-active");
    }
  }
};
