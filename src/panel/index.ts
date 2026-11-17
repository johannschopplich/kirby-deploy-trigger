import ViewButton from "./components/ViewButton.vue";
import { icons } from "./config/icons";

window.panel.plugin("johannschopplich/deploy-trigger", {
  viewButtons: {
    "deploy-trigger": ViewButton,
  },
  icons,
});
