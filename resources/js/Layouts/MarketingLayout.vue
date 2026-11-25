<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import LanguageSwitcher from '@/Components/LanguageSwitcher.vue';
import { useLang } from '@/Composables/useLang';
import { Link, usePage } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

const page = usePage();
const { t, direction } = useLang();
const scrolled = ref(false);
const mobileOpen = ref(false);

const onScroll = () => {
    scrolled.value = window.scrollY > 40;
};

onMounted(() => window.addEventListener('scroll', onScroll, { passive: true }));
onUnmounted(() => window.removeEventListener('scroll', onScroll));

const solid = computed(() => scrolled.value || mobileOpen.value);

const navLinks = computed(() => [
    { label: t('nav.about'), href: '/#about' },
    { label: t('nav.schools'), href: '/schools' },
    { label: t('nav.programs'), href: '/#programs' },
    { label: t('nav.leadership'), href: '/#leadership' },
    { label: t('nav.news'), href: '/#news' },
    { label: t('nav.contact'), href: '/#contact' },
]);
</script>

<template>
    <div class="min-h-screen overflow-x-hidden bg-ivory text-navy-deep" :dir="direction">
        <header
            class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
            :class="
                solid
                    ? 'border-b border-navy/10 bg-ivory/95 shadow-[0_8px_30px_-18px_rgba(14,43,83,0.45)] backdrop-blur-md'
                    : 'bg-transparent'
            "
        >
            <div class="mx-auto flex h-[4.5rem] w-full max-w-6xl items-center justify-between gap-4 px-5 sm:px-8">
                <a href="/#top" class="group flex min-w-0 items-center gap-3">
                    <span class="h-10 w-10 shrink-0 overflow-hidden rounded-full ring-1 ring-gold/40 sm:h-11 sm:w-11">
                        <ApplicationLogo />
                    </span>
                    <span class="min-w-0 leading-tight">
                        <span
                            class="block truncate font-display text-lg font-semibold tracking-wide transition sm:text-xl"
                            :class="solid ? 'text-navy' : 'text-ivory'"
                        >
                            {{ t('brand.name') }}
                        </span>
                        <span
                            class="hidden text-[0.62rem] font-semibold uppercase tracking-[0.2em] sm:block"
                            :class="solid ? 'text-navy-muted' : 'text-ivory/65'"
                        >
                            {{ t('brand.subtitle') }}
                        </span>
                    </span>
                </a>

                <nav class="hidden items-center gap-5 lg:flex xl:gap-6">
                    <a
                        v-for="link in navLinks"
                        :key="link.href"
                        :href="link.href"
                        class="text-[0.8rem] font-medium tracking-wide transition"
                        :class="
                            solid
                                ? 'text-navy-muted hover:text-navy'
                                : 'text-ivory/70 hover:text-gold-soft'
                        "
                    >
                        {{ link.label }}
                    </a>
                </nav>

                <div class="flex items-center gap-2 sm:gap-3">
                    <LanguageSwitcher class="hidden sm:inline-flex" :solid="solid" compact />

                    <template v-if="page.props.auth.user">
                        <Link
                            :href="route('dashboard')"
                            class="rounded-sm px-4 py-2 text-[0.7rem] font-semibold uppercase tracking-[0.16em] transition"
                            :class="
                                solid
                                    ? 'bg-navy text-ivory hover:bg-navy-soft'
                                    : 'bg-gold text-navy-deep hover:bg-gold-bright'
                            "
                        >
                            {{ t('nav.dashboard') }}
                        </Link>
                    </template>
                    <template v-else>
                        <Link
                            v-if="canLogin"
                            :href="route('login')"
                            class="hidden text-[0.8rem] font-medium transition sm:inline"
                            :class="solid ? 'text-navy-muted hover:text-navy' : 'text-ivory/75 hover:text-ivory'"
                        >
                            {{ t('nav.sign_in') }}
                        </Link>
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="rounded-sm px-4 py-2 text-[0.7rem] font-semibold uppercase tracking-[0.16em] transition"
                            :class="
                                solid
                                    ? 'bg-navy text-ivory hover:bg-navy-soft'
                                    : 'bg-ivory text-navy hover:bg-gold-soft'
                            "
                        >
                            {{ t('nav.enroll') }}
                        </Link>
                    </template>

                    <button
                        type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-sm border transition lg:hidden"
                        :class="
                            solid
                                ? 'border-navy/15 text-navy'
                                : 'border-ivory/25 text-ivory'
                        "
                        @click="mobileOpen = !mobileOpen"
                        :aria-expanded="mobileOpen"
                        :aria-label="t('nav.toggle_menu')"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                v-if="!mobileOpen"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M4 7h16M4 12h16M4 17h16"
                            />
                            <path
                                v-else
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M6 6l12 12M18 6L6 18"
                            />
                        </svg>
                    </button>
                </div>
            </div>

            <div v-if="mobileOpen" class="border-t border-navy/10 bg-ivory lg:hidden">
                <div class="mx-auto flex max-w-6xl flex-col gap-1 px-5 py-4 sm:px-8">
                    <a
                        v-for="link in navLinks"
                        :key="link.href"
                        :href="link.href"
                        class="rounded-sm px-3 py-2.5 text-sm font-medium text-navy hover:bg-teal-mist"
                        @click="mobileOpen = false"
                    >
                        {{ link.label }}
                    </a>
                    <div class="mt-2 border-t border-navy/10 pt-3">
                        <LanguageSwitcher solid />
                    </div>
                </div>
            </div>
        </header>

        <main>
            <slot />
        </main>

        <footer class="border-t border-navy/10 bg-navy text-ivory">
            <div class="mx-auto grid w-full max-w-6xl gap-10 px-5 py-14 sm:px-8 md:grid-cols-[1.4fr_1fr_1fr]">
                <div>
                    <div class="flex items-center gap-3">
                        <span class="h-12 w-12 overflow-hidden rounded-full ring-1 ring-gold/30">
                            <ApplicationLogo />
                        </span>
                        <div>
                            <p class="font-display text-xl font-semibold sm:text-2xl">
                                {{ t('brand.full') }}
                            </p>
                            <p class="mt-1 text-[0.65rem] uppercase tracking-[0.22em] text-gold-soft">
                                {{ t('brand.tagline') }}
                            </p>
                        </div>
                    </div>
                    <p class="mt-5 max-w-md text-sm leading-relaxed text-ivory/65">
                        {{ t('footer.blurb') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-gold">{{ t('footer.explore') }}</p>
                    <ul class="mt-4 space-y-2 text-sm text-ivory/70">
                        <li><a href="/#about" class="hover:text-gold-soft">{{ t('footer.about') }}</a></li>
                        <li><a href="/schools" class="hover:text-gold-soft">{{ t('footer.schools') }}</a></li>
                        <li><a href="/#programs" class="hover:text-gold-soft">{{ t('footer.programs') }}</a></li>
                        <li><a href="/#news" class="hover:text-gold-soft">{{ t('footer.news') }}</a></li>
                    </ul>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-gold">{{ t('footer.services') }}</p>
                    <ul class="mt-4 space-y-2 text-sm text-ivory/70">
                        <li>{{ t('footer.workshops') }}</li>
                        <li>{{ t('footer.webinars') }}</li>
                        <li>{{ t('footer.materials') }}</li>
                        <li>{{ t('footer.accreditation') }}</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/10">
                <div class="mx-auto flex w-full max-w-6xl flex-col gap-2 px-5 py-5 text-xs text-ivory/45 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                    <p>{{ t('footer.rights', { year: new Date().getFullYear() }) }}</p>
                    <p>{{ t('brand.tagline') }}</p>
                </div>
            </div>
        </footer>
    </div>
</template>
