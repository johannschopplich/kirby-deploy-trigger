/* eslint-disable ts/ban-ts-comment */
import type { ComponentPublicInstance, PluginFunction } from "vue";
import { isKirby5 } from "kirbyuse";
// @ts-ignore - Vue component
import DeployTriggerButton from "../components/ViewButtons/DeployTriggerButton.vue";

export const legacyViewButtonMixin: PluginFunction<any> = (Vue) => {
  if (isKirby5()) {
    return;
  }

  let buttonComponent: ComponentPublicInstance | undefined;

  Vue.mixin({
    mounted(this: ComponentPublicInstance) {
      if (this.$options.name !== "k-header") return;
      if (window.panel.view.component !== "k-site-view") return;

      const buttonGroup = this.$children.find(
        (child: ComponentPublicInstance) =>
          child.$options.name === "k-button-group",
      );
      if (!buttonGroup) return;

      const ButtonConstructor = Vue.extend(DeployTriggerButton);
      buttonComponent = new ButtonConstructor({ parent: this as any });
      buttonComponent.$mount();

      buttonGroup.$el.after(buttonComponent.$el);
    },
    beforeDestroy(this: ComponentPublicInstance) {
      if (this.$options.name !== "k-header") return;
      if (window.panel.view.component !== "k-site-view") return;

      if (buttonComponent) {
        buttonComponent.$destroy();
        buttonComponent = undefined;
      }
    },
  });
};
