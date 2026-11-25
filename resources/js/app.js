import '../css/app.css';
import './bootstrap';

import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Vertex Academy';

const applyDocumentLocale = (page) => {
    const locale = page?.props?.locale || 'en';
    const direction = page?.props?.direction || 'ltr';

    document.documentElement.lang = String(locale).replace('_', '-');
    document.documentElement.dir = direction;
    document.documentElement.style.direction = direction;
    document.body?.setAttribute('dir', direction);
};

router.on('navigate', (event) => {
    applyDocumentLocale(event.detail.page);
});

createInertiaApp({
    title: (title) => (title ? `${title} · ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        applyDocumentLocale(props.initialPage);

        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#C9A227',
    },
});
