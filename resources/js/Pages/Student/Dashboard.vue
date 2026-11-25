<script setup>
import PortalLayout from '@/Layouts/PortalLayout.vue';
import { useLang } from '@/Composables/useLang';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    student: Object,
    stats: Object,
    recent: Array,
    featured: Array,
});

const { t } = useLang();

const links = computed(() => [
    { label: t('portal.my_desk'), href: route('student.dashboard'), match: 'student.dashboard' },
    { label: t('portal.browse_courses'), href: route('student.courses.index'), match: 'student.courses.*' },
    { label: t('portal.my_library'), href: route('student.library'), match: 'student.library' },
    { label: t('portal.profile'), href: route('profile.edit'), match: 'profile.*' },
]);
</script>

<template>
    <Head :title="t('portal.student')" />

    <PortalLayout portal="student" :title="t('portal.student')" :links="links">
        <template #header>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-teal">{{ t('student.dashboard.welcome') }}</p>
                <h2 class="mt-1 font-display text-3xl font-semibold text-navy">{{ student.name }}</h2>
            </div>
        </template>

        <div class="px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid gap-4 md:grid-cols-3">
                <article class="border border-navy/10 bg-white p-5">
                    <p class="text-xs uppercase tracking-[0.16em] text-navy-muted">{{ t('student.dashboard.library') }}</p>
                    <p class="mt-3 font-display text-4xl text-navy">{{ stats.library }}</p>
                    <p class="mt-2 text-sm text-navy-muted">{{ t('student.dashboard.unlocked') }}</p>
                </article>
                <article class="border border-navy/10 bg-white p-5">
                    <p class="text-xs uppercase tracking-[0.16em] text-navy-muted">{{ t('student.dashboard.pending') }}</p>
                    <p class="mt-3 font-display text-4xl text-navy">{{ stats.pending }}</p>
                    <p class="mt-2 text-sm text-navy-muted">{{ t('student.dashboard.awaiting') }}</p>
                </article>
                <article class="border border-navy/10 bg-white p-5">
                    <p class="text-xs uppercase tracking-[0.16em] text-navy-muted">{{ t('student.dashboard.catalog') }}</p>
                    <p class="mt-3 font-display text-4xl text-navy">{{ stats.available }}</p>
                    <p class="mt-2 text-sm text-navy-muted">{{ t('student.dashboard.published') }}</p>
                </article>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-2">
                <section class="border border-navy/10 bg-white p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="font-display text-2xl font-semibold text-navy">{{ t('student.dashboard.continue') }}</h3>
                        <Link :href="route('student.library')" class="text-xs font-semibold uppercase tracking-[0.12em] text-teal">{{ t('student.dashboard.library') }}</Link>
                    </div>
                    <div v-if="recent.length" class="mt-4 space-y-3">
                        <div v-for="course in recent" :key="course.id" class="border-t border-navy/10 pt-3">
                            <p class="font-medium text-navy">{{ course.title }}</p>
                            <p class="text-xs text-navy-muted">{{ course.type_label }} · {{ course.enrollment?.progress_percent || 0 }}%</p>
                        </div>
                    </div>
                    <p v-else class="mt-3 text-sm text-navy-muted">{{ t('student.dashboard.empty') }}</p>
                </section>

                <section class="border border-navy/10 bg-navy p-6 text-ivory">
                    <div class="flex items-center justify-between">
                        <h3 class="font-display text-2xl font-semibold">{{ t('student.dashboard.featured') }}</h3>
                        <Link :href="route('student.courses.index')" class="text-xs font-semibold uppercase tracking-[0.12em] text-gold-soft">{{ t('portal.browse_courses') }}</Link>
                    </div>
                    <div class="mt-4 space-y-3">
                        <div v-for="course in featured" :key="course.id" class="border-t border-white/10 pt-3">
                            <p class="font-medium">{{ course.title }}</p>
                            <p class="text-xs text-ivory/60">{{ course.type_label }} · {{ course.price_label }}</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </PortalLayout>
</template>
