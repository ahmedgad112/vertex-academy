<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import LanguageSwitcher from '@/Components/LanguageSwitcher.vue';
import { useLang } from '@/Composables/useLang';
import { Link } from '@inertiajs/vue3';

const { t, direction } = useLang();
</script>

<template>
    <div
        class="relative flex min-h-screen flex-col items-center overflow-x-hidden bg-ivory pt-8 sm:justify-center sm:pt-0"
        :dir="direction"
    >
        <div
            class="pointer-events-none absolute inset-0"
            style="background:
                radial-gradient(ellipse 60% 40% at 50% 0%, rgba(46,137,130,0.16), transparent 55%),
                radial-gradient(ellipse 40% 30% at 90% 80%, rgba(201,162,39,0.1), transparent 50%);"
        />

        <div class="absolute end-4 top-4 z-10 sm:end-8 sm:top-8">
            <LanguageSwitcher solid />
        </div>

        <div class="relative">
            <Link :href="route('home')" class="flex flex-col items-center gap-3">
                <span class="h-20 w-20 overflow-hidden rounded-full shadow-lg ring-1 ring-gold/35">
                    <ApplicationLogo />
                </span>
                <div class="text-center">
                    <p class="font-display text-2xl font-semibold text-navy">{{ t('brand.full') }}</p>
                    <p class="text-[0.62rem] uppercase tracking-[0.24em] text-navy-muted">
                        {{ t('brand.tagline') }}
                    </p>
                </div>
            </Link>
        </div>

        <div
            class="relative mt-8 w-full overflow-hidden bg-white px-6 py-8 shadow-[0_20px_50px_-30px_rgba(14,43,83,0.35)] sm:max-w-md sm:rounded-sm sm:border sm:border-navy/10"
        >
            <slot />
        </div>
    </div>
</template>
