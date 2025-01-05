import { isKirby5 } from "kirbyuse";
import DeployTriggerButton from "../components/ViewButtons/DeployTriggerButton.vue";

export function legacyViewButtonMixin(Vue) {
  if (isKirby5()) {
    return;
  }

  Vue.mixin({
    mounted() {
      if (this.$options.name !== "k-header") return;
      if (window.panel.view.component !== "k-site-view") return;

      const buttonGroup = this.$children.find(
        (child) => child.$options.name === "k-button-group",
      );
      if (!buttonGroup) return;

      const button = new Vue({
        render: (h) => h(DeployTriggerButton),
      }).$mount();

      buttonGroup.$el.after(button.$el);
      this.$forceUpdate();
    },
  });
}
