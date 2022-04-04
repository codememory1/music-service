import Vue from "vue";

Vue.directive("hover", {
  inserted: (el, binding) => {
    const hoverClass = binding.value?.class ?? "hover";
    const excludeClasses = binding.value?.exclude_classes ?? [];

    el.onmouseover = (e) => {
      let isHover = true;

      for (let i = 0; i < excludeClasses.length; i++) {
        const excludeClass = excludeClasses[i];
        const excludeClassSelector = el.querySelector(`.${excludeClass}`);

        if (e.composedPath().includes(excludeClassSelector)) {
          isHover = false;

          break;
        }
      }

      if (isHover) {
        el.classList.add(hoverClass);
      }
    };

    el.onmouseout = () => {
      el.classList.remove(hoverClass);
    };
  }
});
