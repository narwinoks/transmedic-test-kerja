<script setup lang="ts">
import { cn } from '../../../lib/utils'

import { type IconButtonVariants, iconButtonVariants } from './index'


type IconButtonVariants = VariantProps<typeof iconButtonVariants>

defineProps<{
    icon: string
    size?: IconButtonVariants['size']
    variant?: IconButtonVariants['variant']
    disabled?: boolean
}>()
</script>

<template>
    <button
        type="button"
        :class="cn(iconButtonVariants({ variant, size }))"
        :disabled="disabled">
        <i :class="icon" />
    </button>
</template>
