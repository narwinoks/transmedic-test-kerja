<script setup lang="ts">
import { RadioGroupIndicator, RadioGroupItem, RadioGroupRoot } from 'reka-ui'

interface Option {
    label: string
    value: string
    id?: string
}

// define & extract props automatically
const props = defineProps<{
    modelValue: string
    options: Option[]
}>()

const emit = defineEmits(['update:modelValue'])

const updateValue = (value: string) => {
    emit('update:modelValue', value)
}

const getId = (option: Option, index: number) => option.id ?? `radio-${index}`
</script>

<template>
    <RadioGroupRoot
        :model-value="props.modelValue"
        @update:model-value="updateValue"
        class="flex gap-2.5"
        aria-label="Radio Options"
    >
        <div
            v-for="(option, index) in props.options"
            :key="option.value"
            class="flex items-center"
        >
            <RadioGroupItem
                :id="getId(option, index)"
                :value="option.value"
                :data-active="modelValue === option.value"
                class="bg-white w-[1.125rem] h-[1.125rem] rounded-full border data-[active=true]:border-stone-700 data-[active=true]:bg-stone-700 dark:data-[active=true]:bg-white shadow-sm focus:shadow-[0_0_0_2px] focus:shadow-stone-700 outline-none cursor-default"
            >
                <RadioGroupIndicator
                    class="flex items-center justify-center w-full h-full relative after:content-[''] after:block after:w-2 after:h-2 after:rounded-[50%] after:bg-white dark:after:bg-stone-700"
                />
            </RadioGroupItem>
            <label
                class="text-stone-700 dark:text-white text-sm leading-none pl-[15px]"
                :for="getId(option, index)"
            >
                {{ option.label }}
            </label>
        </div>
    </RadioGroupRoot>
</template>
