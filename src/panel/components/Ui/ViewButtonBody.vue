<script setup lang="ts">
defineProps({
  label: {
    type: String,
    required: true,
  },
  isDeploying: Boolean,
});

const emit = defineEmits<{
  (event: "click"): void;
}>();
</script>

<template>
  <k-button
    :text="label"
    :icon="isDeploying ? 'loader' : 'deploy-trigger-rocket'"
    :disabled="isDeploying"
    responsive="text"
    theme="blue-icon"
    variant="filled"
    size="sm"
    @click="emit('click')"
  />
</template>
