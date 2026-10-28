import DeployTriggerButton from "./components/ViewButtons/DeployTriggerButton.vue";
import { icons } from "./config/icons";

window.panel.plugin("johannschopplich/deploy-trigger", {
  viewButtons: {
    "deploy-trigger": DeployTriggerButton,
  },
  icons,
});
