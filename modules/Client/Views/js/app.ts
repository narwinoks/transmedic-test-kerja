import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from '/vendor/tightenco/ziggy';
import { initializeTheme } from './composables/useAppearance';

import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import Toast from 'primevue/toast';
import Aura from '@primeuix/themes/lara';
import { createPinia } from 'pinia'
import  {useUserSession} from './storage/useSessionStorage';
// icon css
declare module 'vite/client' {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string;
        [key: string]: string | boolean | undefined;
    }

    interface ImportMeta {
        readonly env: ImportMetaEnv;
        readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
    }
}

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue')
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        const pinia = createPinia()
        app.use(plugin);
        app.use(pinia);
        app.use(ZiggyVue);

        app.use(PrimeVue, {
            theme: {
                preset: Aura,
                options: {
                    prefix: 'p',
                    darkModeSelector: 'dark',
                    cssLayer: false,
                    locale: {
                        firstDayOfWeek: 1,
                        dayNames: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
                        dayNamesShort: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
                        dayNamesMin: ["Mg", "Sn", "Sl", "Rb", "Km", "Jm", "Sb"],
                        monthNames: [
                            "Januari",
                            "Februari",
                            "Maret",
                            "April",
                            "Mei",
                            "Juni",
                            "Juli",
                            "Agustus",
                            "September",
                            "Oktober",
                            "November",
                            "Desember",
                        ],
                        monthNamesShort: [
                            "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des",
                        ],
                        today: "Hari Ini",
                        clear: "Bersihkan",
                        dateFormat: "dd/mm/yy",
                        fileSizeTypes: ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
                    },
                }
            }
        });

        app.use(ToastService);

        app.component('Toast', Toast);

        app.mount(el);
        app.mixin({
            beforeMount() {
                const userSession = useUserSession()

                const currentPage = this.$page.component.toLowerCase()
                const isLoginPage = currentPage.includes('login');

                if (!isLoginPage && !userSession.isLoggedIn) {
                    this.$inertia.visit('/auth/login', {
                        replace: true,
                        preserveState: false,
                    })
                }
            }
        })
    },
    progress: {
        color: '#4B5563',
    },
});

initializeTheme();
