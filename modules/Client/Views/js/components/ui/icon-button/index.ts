import IconButton from './IconButton.vue'
import { cva, type VariantProps } from 'class-variance-authority'

export const iconButtonVariants = cva(
    'inline-flex items-center justify-center rounded-md transition-colors disabled:opacity-50 disabled:pointer-events-none focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2',
    {
        variants: {
            variant: {
                default: 'bg-primary text-white hover:bg-primary/90',
                ghost: 'hover:bg-accent hover:text-accent-foreground',
                outline: 'border border-input bg-transparent hover:bg-accent',
            },
            size: {
                default: 'h-9 w-9 text-base',
                sm: 'h-8 w-8 text-sm',
                lg: 'h-10 w-10 text-lg',
            },
        },
        defaultVariants: {
            variant: 'ghost',
            size: 'default',
        },
    }
)

export type IconButtonVariants = VariantProps<typeof iconButtonVariants>

export default IconButton
