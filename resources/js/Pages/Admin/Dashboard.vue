<script setup>
import PortalLayout from '@/Layouts/PortalLayout.vue';
import { useLang } from '@/Composables/useLang';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    stats: Object,
    recentCourses: Array,
});

const { t } = useLang();

const links = computed(() => [
    { label: t('portal.overview'), href: route('admin.dashboard'), match: 'admin.dashboard' },
    { label: t('portal.courses'), href: route('admin.courses.index'), match: 'admin.courses.*' },
    { label: t('portal.users'), href: route('admin.users.index'), match: 'admin.users.*' },
    { label: t('portal.profile'), href: route('profile.edit'), match: 'profile.*' },
]);

const money = (cents) => `USD ${(Number(cents || 0) / 100).toFixed(2)}`;
</script>

<template>
    <Head :title="t('portal.admin')" />

    <PortalLayout portal="admin" :title="t('portal.admin')" :links="links">
        <template #header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-muted">Command center</p>
                    <h2 class="mt-1 font-display text-3xl font-semibold text-navy">Academy overview</h2>
                </div>
                <Link :href="route('admin.courses.create')" class="text-sm font-semibold text-teal hover:text-navy">
                    Add course →
                </Link>
            </div>
        </template>

        <div class="px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <article class="border border-navy/10 bg-white p-5">
                    <p class="text-xs uppercase tracking-[0.16em] text-navy-muted">Students</p>
                    <p class="mt-3 font-display text-4xl text-navy">{{ stats.students }}</p>
                </article>
                <article class="border border-navy/10 bg-white p-5">
                    <p class="text-xs uppercase tracking-[0.16em] text-navy-muted">Courses</p>
                    <p class="mt-3 font-display text-4xl text-navy">{{ stats.courses }}</p>
                </article>
                <article class="border border-navy/10 bg-white p-5">
                    <p class="text-xs uppercase tracking-[0.16em] text-navy-muted">Active enrollments</p>
                    <p class="mt-3 font-display text-4xl text-navy">{{ stats.active_enrollments }}</p>
                </article>
                <article class="border border-navy/10 bg-white p-5">
                    <p class="text-xs uppercase tracking-[0.16em] text-navy-muted">Revenue</p>
                    <p class="mt-3 font-display text-3xl text-navy">{{ money(stats.revenue_cents) }}</p>
                </article>
            </div>

            <div class="mt-4 grid gap-4 md:grid-cols-3">
                <article class="border border-navy/10 bg-white p-4">
                    <p class="text-xs uppercase tracking-[0.14em] text-teal">Free</p>
                    <p class="mt-2 font-display text-3xl text-navy">{{ stats.free_courses }}</p>
                </article>
                <article class="border border-navy/10 bg-white p-4">
                    <p class="text-xs uppercase tracking-[0.14em] text-teal">Short</p>
                    <p class="mt-2 font-display text-3xl text-navy">{{ stats.short_courses }}</p>
                </article>
                <article class="border border-navy/10 bg-white p-4">
                    <p class="text-xs uppercase tracking-[0.14em] text-teal">Paid</p>
                    <p class="mt-2 font-display text-3xl text-navy">{{ stats.paid_courses }}</p>
                </article>
            </div>

            <section class="mt-8 border border-navy/10 bg-white p-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-display text-2xl font-semibold text-navy">Recent courses</h3>
                    <Link :href="route('admin.courses.index')" class="text-xs font-semibold uppercase tracking-[0.12em] text-teal">View all</Link>
                </div>
                <div class="mt-4 space-y-3">
                    <div v-for="course in recentCourses" :key="course.id" class="flex items-center justify-between border-t border-navy/10 pt-3">
                        <div>
                            <p class="font-medium text-navy">{{ course.title }}</p>
                            <p class="text-xs text-navy-muted">{{ course.type_label }} · {{ course.status_label }} · {{ course.price_label }}</p>
                        </div>
                        <Link :href="route('admin.courses.edit', course.id)" class="text-xs font-semibold uppercase tracking-[0.12em] text-teal">Edit</Link>
                    </div>
                </div>
            </section>
        </div>
    </PortalLayout>
</template>
