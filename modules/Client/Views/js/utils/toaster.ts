import { useToast } from 'primevue/usetoast'
import { createSharedComposable } from '@vueuse/core'

export const useToaster = createSharedComposable(() => {    
    const toast = useToast();
    return {
        success: (message: any, title: any = null) => {    
            title = title ? title : 'Info'
            return toast.add({ severity: 'success', summary: title, detail: message, life: 3000, group: 'br' })
        },
        error: (message: any, title: any = null) => {
            // const toast = useToast()
            
            title = title ? title : 'Info'
            return toast.add({ severity: 'error', summary: title, detail: message, life: 3000, group: 'br' })
        },
        info: (message: any, title: any = null) => {
            // const toast = useToast()
            title = title ? title : 'Info'
            return toast.add({ severity: 'info', summary: title, detail: message, life: 3000, group: 'br' })
        },
        warn: (message: any, title: any = null) => {
            // const toast = useToast()
            title = title ? title : 'Info'
            return toast.add({ severity: 'warn', summary: title, detail: message, life: 3000, group: 'br' })
        },
        dismissAll: () => {
            // const toast = useToast()
            toast.removeAllGroups()
        },
    }
})
