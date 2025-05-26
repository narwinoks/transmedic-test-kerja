import { acceptHMRUpdate, defineStore } from 'pinia'
import { computed } from 'vue'
import { useStorage } from '@vueuse/core'

export const useUserSession = defineStore('userSession', () => {
    const token = useStorage('token', '')

    const isLoggedIn = computed(() => token.value !== '' && token.value !== undefined)

    function setToken(newToken: string) {
        token.value = newToken
    }

    function logout() {
        token.value = ''
    }

    return {
        token,
        isLoggedIn,
        setToken,
        logout,
    }
})

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useUserSession, import.meta.hot))
}
