<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '../../../lib/utils'

const props = defineProps<{
    class?: HTMLAttributes['class']
    isRounded?: boolean
}>()
</script>

<template>
    <div
        data-slot="card"
        :class="cn(
      'bg-white text-gray-800 dark:bg-gray-900 dark:text-white dark:border-gray-700 flex flex-col gap-4 border border-gray-200 p-4',
      props.isRounded ? 'rounded-lg' : 'rounded-none',
      props.class
    )"
    >
        <slot />
    </div>
</template>

<style lang="scss">


</style>
