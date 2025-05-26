<script setup lang="ts">
import Breadcrumbs from './Breadcrumbs.vue';
import type { BreadcrumbItemType } from '../types';
import { AvatarImage,Avatar,AvatarFallback } from './ui/avatar';

withDefaults(defineProps<{
    breadcrumbs?: BreadcrumbItemType[];
}>(),{
    breadcrumbs:()=>[]
});
</script>

<template>
    <header  class="flex bg-white dark:bg-[hsl(240,4%,12%)] justify-between h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height]  ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4">
            <div class="flex items-center gap-3">
                <img src="https://v2-dev-simrs.transmedic.co.id/img/logo_t.png" alt="Logo" class="w-10 h-10" >
                <div class="leading-tight">
                    <h1 class="text-base font-semibold text-gray-800 dark:text-white">RS Transmedic</h1>
                    <template v-if="breadcrumbs && breadcrumbs.length > 0">
                        <Breadcrumbs :breadcrumbs="breadcrumbs" />
                    </template>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex flex-col items-center justify-center border cursor-pointer rounded-md px-2 py-1 hover:bg-gray-100 transition">
                    <i class="fas fa-bars text-lg mb-1 text-gray-700"></i>
                    <p class="text-[10px] font-light text-gray-600 leading-tight">Navigasi</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <Avatar class="cursor-pointer">
                    <AvatarImage src="/avatar.png" alt="User Avatar" />
                    <AvatarFallback>U</AvatarFallback>
                </Avatar>
            </div>
    </header>
</template>
