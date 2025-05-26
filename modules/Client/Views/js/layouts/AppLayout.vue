<script setup lang="ts">
import AppLayout from './app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '../types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto">
            <slot />
        </div>
    </AppLayout>
</template>
