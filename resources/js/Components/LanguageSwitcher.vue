<script setup>
import { computed } from 'vue';
import { useLang } from '@/Composables/useLang';

defineProps({
    solid: {
        type: Boolean,
        default: true,
    },
    compact: {
        type: Boolean,
        default: false,
    },
});

const { locale, locales, setLocale, t } = useLang();

const orderedLocales = computed(() => {
    const english = locales.value.find((item) => item.code === 'en');
    const arabic = locales.value.find((item) => item.code === 'ar');
    const rest = locales.value.filter((item) => item.code !== 'en' && item.code !== 'ar');

    return [english, ...rest, arabic].filter(Boolean);
});
</script>

<template>
    <!-- Keep EN on the left and AR on the right even when the page is RTL -->
    <div
        class="inline-flex flex-row items-center gap-1"
        dir="ltr"
        :aria-label="t('nav.language')"
    >
        <button
            v-for="option in orderedLocales"
            :key="option.code"
            type="button"
            class="rounded-sm px-2 py-1 text-[0.68rem] font-semibold uppercase tracking-[0.12em] transition"
            :class="
                locale === option.code
                    ? solid
                        ? 'bg-navy text-ivory'
                        : 'bg-gold text-navy-deep'
                    : solid
                      ? 'text-navy-muted hover:text-navy'
                      : 'text-ivory/70 hover:text-ivory'
            "
            @click="setLocale(option.code)"
        >
            {{ compact ? option.code.toUpperCase() : option.native_label }}
        </button>
    </div>
</template>
