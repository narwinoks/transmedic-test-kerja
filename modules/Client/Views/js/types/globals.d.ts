import type { route as routeFn } from '../../../../../vendor/tightenco/ziggy';

declare global {
    const route: typeof routeFn;
}
