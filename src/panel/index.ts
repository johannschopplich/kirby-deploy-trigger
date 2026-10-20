import DeployTriggerButton from "./components/ViewButtons/DeployTriggerButton.vue";
import { icons } from "./config/icons";
import { legacyViewButtonMixin } from "./utils/legacy";

window.panel.plugin("johannschopplich/deploy-trigger", {
  viewButtons: {
    "deploy-trigger": DeployTriggerButton,
  },
  icons,
  use: [legacyViewButtonMixin],
});
