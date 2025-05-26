<script setup lang="ts">
import AuthLayout from './auth/AuthSimpleLayout.vue';
import {useToaster} from "../utils/toaster";
useToaster();
defineProps<{
    title?: string;
    description?: string;
}>();
    console.log("call  layout.");
</script>

<template>
    <AuthLayout :title="title" :description="description">
        <Toast position="bottom-right" group="br" />
        <slot />
    </AuthLayout>
</template>
