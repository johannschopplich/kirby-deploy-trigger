import { isKirby5 } from "kirbyuse";
import DeployTriggerButton from "../components/ViewButtons/DeployTriggerButton.vue";

export function legacyViewButtonMixin(Vue) {
  if (isKirby5()) {
    return;
  }

  let buttonComponent;

  Vue.mixin({
    mounted() {
      if (this.$options.name !== "k-header") return;
      if (window.panel.view.component !== "k-site-view") return;

      const buttonGroup = this.$children.find(
        (child) => child.$options.name === "k-button-group",
      );
      if (!buttonGroup) return;

      const ButtonConstructor = Vue.extend(DeployTriggerButton);
      buttonComponent = new ButtonConstructor({ parent: this });
      buttonComponent.$mount();

      buttonGroup.$el.after(buttonComponent.$el);
    },
    beforeDestroy() {
      if (this.$options.name !== "k-header") return;
      if (window.panel.view.component !== "k-site-view") return;

      if (buttonComponent) {
        buttonComponent.$destroy();
        buttonComponent = undefined;
      }
    },
  });
}
