<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const stats = [
    { label: 'Active Programs', value: '12', hint: 'Across 4 schools' },
    { label: 'Open Enrollments', value: '48', hint: 'Awaiting review' },
    { label: 'Upcoming Webinars', value: '6', hint: 'Next 30 days' },
    { label: 'Partner Orgs', value: '18', hint: 'Success network' },
];

const schools = [
    'Laboratory Medicine',
    'Quality, Patient Safety & Accreditation',
    'Healthcare Informatics & Digital Health',
    'Management, Leadership & Governance',
];

const queue = [
    { title: 'Microbiology cohort — payment verification', meta: 'Enrollment', tone: 'gold' },
    { title: 'Workshop proposal: Molecular diagnostics lab', meta: 'Workshop', tone: 'teal' },
    { title: 'News draft: Advisory board announcement', meta: 'News Desk', tone: 'navy' },
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-teal">
                        Academy Desk
                    </p>
                    <h2 class="mt-1 font-display text-3xl font-semibold text-navy">
                        Command overview
                    </h2>
                </div>
                <Link
                    :href="route('home')"
                    class="text-sm font-medium text-navy-muted transition hover:text-navy"
                >
                    Open public site →
                </Link>
            </div>
        </template>

        <div class="px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <article
                    v-for="stat in stats"
                    :key="stat.label"
                    class="border border-navy/10 bg-white p-5"
                >
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-navy-muted">
                        {{ stat.label }}
                    </p>
                    <p class="mt-3 font-display text-4xl font-semibold text-navy">
                        {{ stat.value }}
                    </p>
                    <p class="mt-2 text-sm text-teal-dark">{{ stat.hint }}</p>
                </article>
            </div>

            <div class="mt-8 grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
                <section class="border border-navy/10 bg-white">
                    <div class="border-b border-navy/10 px-6 py-5">
                        <h3 class="font-display text-2xl font-semibold text-navy">
                            Attention queue
                        </h3>
                        <p class="mt-1 text-sm text-navy-muted">
                            Items that need review from the academy team.
                        </p>
                    </div>
                    <ul class="divide-y divide-navy/10">
                        <li
                            v-for="item in queue"
                            :key="item.title"
                            class="flex items-start justify-between gap-4 px-6 py-5"
                        >
                            <div>
                                <p class="font-medium text-navy">{{ item.title }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.16em] text-navy-muted">
                                    {{ item.meta }}
                                </p>
                            </div>
                            <span
                                class="shrink-0 rounded-sm px-2.5 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.14em]"
                                :class="{
                                    'bg-gold-soft/40 text-gold-muted': item.tone === 'gold',
                                    'bg-teal-mist text-teal-dark': item.tone === 'teal',
                                    'bg-navy/5 text-navy': item.tone === 'navy',
                                }"
                            >
                                Review
                            </span>
                        </li>
                    </ul>
                </section>

                <section class="border border-navy/10 bg-navy p-6 text-ivory">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-gold-soft">
                        Schools
                    </p>
                    <h3 class="mt-3 font-display text-3xl font-semibold">
                        Four pillars of Vertex
                    </h3>
                    <ul class="mt-8 space-y-4">
                        <li
                            v-for="(school, index) in schools"
                            :key="school"
                            class="border-t border-white/10 pt-4"
                        >
                            <p class="text-xs text-gold-soft">0{{ index + 1 }}</p>
                            <p class="mt-1 font-display text-xl">{{ school }}</p>
                        </li>
                    </ul>
                </section>
            </div>

            <section class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="border border-navy/10 bg-white p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-teal">
                        Next step
                    </p>
                    <h4 class="mt-3 font-display text-2xl font-semibold text-navy">
                        Publish a program
                    </h4>
                    <p class="mt-2 text-sm text-navy-muted">
                        Add curriculum, ILOs, credentials, and enrollment fields.
                    </p>
                </div>
                <div class="border border-navy/10 bg-white p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-teal">
                        Content
                    </p>
                    <h4 class="mt-3 font-display text-2xl font-semibold text-navy">
                        Update news desk
                    </h4>
                    <p class="mt-2 text-sm text-navy-muted">
                        Keep the landing page current with academy announcements.
                    </p>
                </div>
                <div class="border border-navy/10 bg-white p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-teal">
                        Growth
                    </p>
                    <h4 class="mt-3 font-display text-2xl font-semibold text-navy">
                        Invite partners
                    </h4>
                    <p class="mt-2 text-sm text-navy-muted">
                        Expand the success partners strip with verified alliances.
                    </p>
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
