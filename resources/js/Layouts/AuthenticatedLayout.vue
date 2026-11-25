<script setup>
import { computed, ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link, usePage } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const page = usePage();

const links = computed(() => [
    {
        name: 'Dashboard',
        route: page.props.auth.user.portal,
        match: page.props.auth.user.portal,
    },
    { name: 'Profile', route: 'profile.edit', match: 'profile.*' },
]);

const isActive = (match) => route().current(match);
</script>

<template>
    <div class="min-h-screen bg-ivory">
        <div class="lg:flex">
            <!-- Sidebar -->
            <aside
                class="hidden w-72 shrink-0 flex-col border-e border-navy/10 bg-navy text-ivory lg:flex lg:min-h-screen"
            >
                <div class="flex items-center gap-3 border-b border-white/10 px-6 py-6">
                    <Link :href="route($page.props.auth.user.portal)" class="flex items-center gap-3">
                        <span class="h-11 w-11 overflow-hidden rounded-full ring-1 ring-gold/35">
                            <ApplicationLogo />
                        </span>
                        <div>
                            <p class="font-display text-xl font-semibold leading-none">Vertex</p>
                            <p class="mt-1 text-[0.65rem] uppercase tracking-[0.2em] text-gold-soft">
                                Academy Desk
                            </p>
                        </div>
                    </Link>
                </div>

                <nav class="flex-1 space-y-1 px-4 py-6">
                    <p class="px-3 pb-2 text-[0.65rem] font-semibold uppercase tracking-[0.22em] text-ivory/40">
                        Overview
                    </p>
                    <Link
                        v-for="link in links"
                        :key="link.route"
                        :href="route(link.route)"
                        class="flex items-center rounded-sm px-3 py-2.5 text-sm transition"
                        :class="
                            isActive(link.match)
                                ? 'bg-white/10 text-gold-soft'
                                : 'text-ivory/75 hover:bg-white/5 hover:text-ivory'
                        "
                    >
                        {{ link.name }}
                    </Link>

                    <p class="px-3 pb-2 pt-8 text-[0.65rem] font-semibold uppercase tracking-[0.22em] text-ivory/40">
                        Academy
                    </p>
                    <div class="space-y-1 px-3 text-sm text-ivory/55">
                        <p class="py-1.5">Schools & Programs</p>
                        <p class="py-1.5">Enrollments</p>
                        <p class="py-1.5">Workshops</p>
                        <p class="py-1.5">News Desk</p>
                        <p class="py-1.5">Partners</p>
                    </div>
                </nav>

                <div class="border-t border-white/10 px-6 py-5">
                    <Link
                        :href="route('home')"
                        class="text-xs uppercase tracking-[0.18em] text-teal-soft transition hover:text-gold-soft"
                    >
                        ← View website
                    </Link>
                </div>
            </aside>

            <div class="min-w-0 flex-1">
                <!-- Top bar -->
                <nav class="border-b border-navy/10 bg-white">
                    <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center gap-3 lg:hidden">
                            <Link :href="route($page.props.auth.user.portal)" class="h-9 w-9 overflow-hidden rounded-full">
                                <ApplicationLogo />
                            </Link>
                            <p class="font-display text-lg font-semibold text-navy">Vertex Desk</p>
                        </div>

                        <div class="hidden lg:block">
                            <p class="text-sm text-navy-muted">
                                Welcome back,
                                <span class="font-semibold text-navy">{{ page.props.auth.user.name }}</span>
                            </p>
                        </div>

                        <div class="hidden sm:flex sm:items-center">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button
                                        type="button"
                                        class="inline-flex items-center rounded-sm border border-navy/10 bg-ivory px-3 py-2 text-sm font-medium text-navy transition hover:border-teal/40"
                                    >
                                        {{ page.props.auth.user.name }}
                                        <svg
                                            class="-me-0.5 ms-2 h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">
                                        Profile
                                    </DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        Log Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>

                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center rounded-sm p-2 text-navy-muted transition hover:bg-ivory hover:text-navy"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div
                        :class="{
                            block: showingNavigationDropdown,
                            hidden: !showingNavigationDropdown,
                        }"
                        class="border-t border-navy/10 sm:hidden"
                    >
                        <div class="space-y-1 px-3 py-3">
                            <Link
                                v-for="link in links"
                                :key="link.route"
                                :href="route(link.route)"
                                class="block rounded-sm px-3 py-2 text-sm"
                                :class="
                                    isActive(link.match)
                                        ? 'bg-teal-mist text-navy'
                                        : 'text-navy-muted'
                                "
                            >
                                {{ link.name }}
                            </Link>
                            <Link
                                :href="route('home')"
                                class="block rounded-sm px-3 py-2 text-sm text-navy-muted"
                            >
                                View website
                            </Link>
                        </div>
                        <div class="border-t border-navy/10 px-4 py-3">
                            <div class="text-base font-medium text-navy">
                                {{ page.props.auth.user.name }}
                            </div>
                            <div class="text-sm text-navy-muted">
                                {{ page.props.auth.user.email }}
                            </div>
                            <div class="mt-3 space-y-1">
                                <Link
                                    :href="route('profile.edit')"
                                    class="block rounded-sm px-3 py-2 text-sm text-navy-muted"
                                >
                                    Profile
                                </Link>
                                <Link
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="block w-full rounded-sm px-3 py-2 text-left text-sm text-navy-muted"
                                >
                                    Log Out
                                </Link>
                            </div>
                        </div>
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
