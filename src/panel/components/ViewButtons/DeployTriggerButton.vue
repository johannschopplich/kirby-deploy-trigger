<script setup>
import { ref, usePanel } from "kirbyuse";

const panel = usePanel();
const isDeploying = ref(false);

async function triggerDeploy() {
  isDeploying.value = true;

  try {
    await Promise.all([
      panel.api.post("__deploy-trigger__/hook"),
      new Promise((resolve) => setTimeout(resolve, 2000)),
    ]);

    panel.notification.success(
      panel.t("johannschopplich.deploy-trigger.success"),
    );
  } catch (error) {
    console.error(error);
    panel.notification.error(error.message);
  } finally {
    isDeploying.value = false;
  }
}
</script>

<template>
  <div>
    <k-button
      :text="panel.t('johannschopplich.deploy-trigger.label')"
      :icon="isDeploying ? 'loader' : 'deploy-trigger-rocket'"
      responsive="text"
      theme="blue-icon"
      variant="filled"
      size="sm"
      @click="triggerDeploy()"
    >
    </k-button>
  </div>
</template>
