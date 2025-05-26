<script setup lang="ts">
import AppLogoIcon from '../../components/AppLogoIcon.vue';
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import IconButton from '../../components/ui/icon-button';

defineProps<{
    title?: string;
    description?: string;
}>();
const isDark = ref(false)
const iconClass = computed(() => isDark.value ? 'fas fa-moon' : 'fas fa-sun')
function toggleDarkMode() {
    const current = localStorage.getItem('appearance') || 'system';
    const next = current === 'dark' ? 'light' : 'dark';
    isDark.value = next !== 'dark';
    localStorage.setItem('appearance', next);
    applyAppearance(next);
}

function applyAppearance(mode) {
    document.documentElement.classList.remove('light', 'dark');

    if (mode === 'system') {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        document.documentElement.classList.add(prefersDark ? 'dark' : 'light');
    } else {
        document.documentElement.classList.add(mode);
    }
}
</script>

<template>
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
        <IconButton
            :icon="iconClass"
            @click="toggleDarkMode"
            variant="outline"
            size="default"
            class="absolute top-10 right-5 transition delay-150 duration-300 ease-in-out"
        />
        <div class="w-full max-w-sm">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <Link :href="'#'" class="flex flex-col items-center gap-2 font-medium">
                        <div class="mb-1 flex h-9 w-9 items-center justify-center rounded-md">
                            <AppLogoIcon class="size-9 fill-current text-[var(--foreground)] dark:text-white" />
                        </div>
                        <span class="sr-only">{{ title }}</span>
                    </Link>
                    <div class="space-y-2 text-center">
                        <h1 class="text-xl font-medium">{{ title }}</h1>
                        <p class="text-center text-sm text-muted-foreground">{{ description }}</p>
                    </div>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
