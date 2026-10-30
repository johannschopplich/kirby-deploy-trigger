<script setup lang="ts">
import { usePanel } from "kirbyuse";
import { ref } from "vue";
import DeployTriggerButtonBody from "../Ui/DeployTriggerButtonBody.vue";

// The view button props Kirby passes (`disabled`, `responsive`, …) would override the button's own.
defineOptions({ inheritAttrs: false });

const panel = usePanel();
const isDeploying = ref(false);

async function triggerDeploy() {
  if (isDeploying.value) return;
  isDeploying.value = true;

  try {
    await Promise.all([
      (async () => {
        const { data } = await panel.api.post("__deploy-trigger__/hook");
        // eslint-disable-next-line no-console
        console.log("Deploy trigger response:", data);
      })(),
      new Promise((resolve) => setTimeout(resolve, 1500)),
    ]);

    panel.notification.success(
      panel.t("johannschopplich.deploy-trigger.success"),
    );
  } catch (error) {
    console.error(error);
    panel.notification.error((error as Error).message);
  } finally {
    isDeploying.value = false;
  }
}
</script>

<template>
  <DeployTriggerButtonBody
    :label="panel.t('johannschopplich.deploy-trigger.label')"
    :is-deploying="isDeploying"
    @click="triggerDeploy()"
  />
</template>
