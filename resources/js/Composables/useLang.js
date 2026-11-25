import { computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';

export function useLang() {
    const page = usePage();

    const locale = computed(() => page.props.locale || 'en');
    const direction = computed(() => page.props.direction || 'ltr');
    const isRtl = computed(() => direction.value === 'rtl');
    const locales = computed(() => page.props.locales || []);
    const translations = computed(() => page.props.translations || {});

    const t = (key, replace = {}) => {
        let text = translations.value[key] ?? key;

        Object.entries(replace).forEach(([name, value]) => {
            text = text.replaceAll(`:${name}`, String(value));
        });

        return text;
    };

    const setLocale = (nextLocale) => {
        if (nextLocale === locale.value) {
            return;
        }

        router.post(
            route('locale.update', nextLocale),
            {},
            {
                preserveScroll: true,
                preserveState: false,
                onSuccess: (page) => {
                    document.documentElement.lang = String(page.props.locale || nextLocale).replace('_', '-');
                    document.documentElement.dir = page.props.direction || (nextLocale === 'ar' ? 'rtl' : 'ltr');
                    document.documentElement.style.direction = document.documentElement.dir;
                    document.body?.setAttribute('dir', document.documentElement.dir);
                },
            },
        );
    };

    return {
        t,
        locale,
        direction,
        isRtl,
        locales,
        setLocale,
    };
}
