<script setup lang="ts">
import AppLayout from './app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '../types';
import {useToaster} from "./toaster";


interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Toast position="bottom-right" group="br" />
        <div class="container mx-auto">
            <slot />
        </div>
    </AppLayout>
</template>
