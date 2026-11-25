<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import LanguageSwitcher from '@/Components/LanguageSwitcher.vue';
import { useLang } from '@/Composables/useLang';
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    portal: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    links: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();
const { t, direction } = useLang();
const mobileOpen = ref(false);

const accent = computed(() => {
    if (props.portal === 'admin') {
        return {
            sidebar: 'bg-navy',
            chip: 'bg-gold/20 text-gold-soft',
        };
    }

    if (props.portal === 'instructor') {
        return {
            sidebar: 'bg-teal-dark',
            chip: 'bg-teal-mist text-teal-dark',
        };
    }

    return {
        sidebar: 'bg-navy-soft',
        chip: 'bg-white/10 text-gold-soft',
    };
});

const isActive = (match) => route().current(match);
</script>

<template>
    <div class="min-h-screen bg-ivory" :dir="direction">
        <div class="lg:flex">
            <aside
                class="hidden w-72 shrink-0 flex-col text-ivory lg:flex lg:min-h-screen ltr:border-e rtl:border-s border-white/5"
                :class="accent.sidebar"
            >
                <div class="flex items-center gap-3 border-b border-white/10 px-6 py-6">
                    <span class="h-11 w-11 overflow-hidden rounded-full ring-1 ring-gold/35">
                        <ApplicationLogo />
                    </span>
                    <div>
                        <p class="font-display text-xl font-semibold leading-none">Vertex</p>
                        <p class="mt-1 text-[0.65rem] uppercase tracking-[0.2em] text-gold-soft">
                            {{ title }}
                        </p>
                    </div>
                </div>

                <nav class="flex-1 space-y-1 px-4 py-6">
                    <Link
                        v-for="link in links"
                        :key="link.href"
                        :href="link.href"
                        class="flex items-center rounded-sm px-3 py-2.5 text-sm transition"
                        :class="
                            isActive(link.match)
                                ? 'bg-white/10 text-gold-soft'
                                : 'text-ivory/75 hover:bg-white/5 hover:text-ivory'
                        "
                    >
                        {{ link.label }}
                    </Link>
                </nav>

                <div class="border-t border-white/10 px-6 py-5">
                    <Link
                        :href="route('home')"
                        class="text-xs uppercase tracking-[0.18em] text-teal-soft transition hover:text-gold-soft"
                    >
                        <span aria-hidden="true" class="inline-block rtl:rotate-180">←</span>
                        {{ t('nav.public_site') }}
                    </Link>
                </div>
            </aside>

            <div class="min-w-0 flex-1">
                <nav class="border-b border-navy/10 bg-white">
                    <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center gap-3 lg:hidden">
                            <span class="h-9 w-9 overflow-hidden rounded-full">
                                <ApplicationLogo />
                            </span>
                            <p class="font-display text-lg font-semibold text-navy">{{ title }}</p>
                        </div>

                        <div class="hidden lg:flex lg:items-center lg:gap-3">
                            <span
                                class="rounded-sm px-2.5 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.16em]"
                                :class="accent.chip"
                            >
                                {{ page.props.auth.user.role_label }}
                            </span>
                            <p class="text-sm text-navy-muted">
                                {{ page.props.auth.user.name }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <LanguageSwitcher solid compact />

                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button
                                        type="button"
                                        class="inline-flex items-center rounded-sm border border-navy/10 bg-ivory px-3 py-2 text-sm font-medium text-navy"
                                    >
                                        {{ t('nav.account') }}
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">{{ t('nav.profile') }}</DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        {{ t('nav.logout') }}
                                    </DropdownLink>
                                </template>
                            </Dropdown>

                            <button
                                type="button"
                                class="inline-flex h-10 w-10 items-center justify-center rounded-sm border border-navy/10 text-navy lg:hidden"
                                @click="mobileOpen = !mobileOpen"
                            >
                                <span class="sr-only">Menu</span>
                                ☰
                            </button>
                        </div>
                    </div>

                    <div v-if="mobileOpen" class="border-t border-navy/10 px-4 py-3 lg:hidden">
                        <Link
                            v-for="link in links"
                            :key="link.href"
                            :href="link.href"
                            class="block rounded-sm px-3 py-2 text-sm text-navy"
                            @click="mobileOpen = false"
                        >
                            {{ link.label }}
                        </Link>
                    </div>
                </nav>

                <header v-if="$slots.header" class="border-b border-navy/10 bg-white">
                    <div class="px-4 py-6 sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <main>
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
