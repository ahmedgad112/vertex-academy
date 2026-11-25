<script setup>
import MarketingLayout from '@/Layouts/MarketingLayout.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { useLang } from '@/Composables/useLang';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

const { t } = useLang();

const schools = computed(() => [
    {
        code: '01',
        slug: 'laboratory-medicine',
        name: t('home.school.01.name'),
        blurb: t('home.school.01.blurb'),
    },
    {
        code: '02',
        slug: 'quality-patient-safety-accreditation',
        name: t('home.school.02.name'),
        blurb: t('home.school.02.blurb'),
    },
    {
        code: '03',
        slug: 'healthcare-informatics-digital-health',
        name: t('home.school.03.name'),
        blurb: t('home.school.03.blurb'),
    },
    {
        code: '04',
        slug: 'management-leadership-governance',
        name: t('home.school.04.name'),
        blurb: t('home.school.04.blurb'),
    },
]);

const objectives = computed(() => [
    t('home.objectives.1'),
    t('home.objectives.2'),
    t('home.objectives.3'),
    t('home.objectives.4'),
]);

const achievements = computed(() => [
    { value: '4', label: t('home.achievements.schools') },
    { value: '20+', label: t('home.achievements.tracks') },
    { value: t('home.achievements.global'), label: t('home.achievements.network') },
    { value: 'AI+', label: t('home.achievements.edge') },
]);

const services = computed(() => [
    {
        title: t('home.services.workshops.title'),
        text: t('home.services.workshops.text'),
    },
    {
        title: t('home.services.webinars.title'),
        text: t('home.services.webinars.text'),
    },
    {
        title: t('home.services.materials.title'),
        text: t('home.services.materials.text'),
    },
    {
        title: t('home.services.accreditation.title'),
        text: t('home.services.accreditation.text'),
    },
]);

const news = computed(() => [
    {
        tag: t('home.news.1.tag'),
        title: t('home.news.1.title'),
        date: t('home.news.1.date'),
    },
    {
        tag: t('home.news.2.tag'),
        title: t('home.news.2.title'),
        date: t('home.news.2.date'),
    },
    {
        tag: t('home.news.3.tag'),
        title: t('home.news.3.title'),
        date: t('home.news.3.date'),
    },
]);

const programItems = computed(() => [
    t('home.programs.about'),
    t('home.programs.prereq'),
    t('home.programs.duration'),
    t('home.programs.curriculum'),
    t('home.programs.certs'),
    t('home.programs.enrollment'),
]);
</script>

<template>
    <Head :title="t('home.title')" />

    <MarketingLayout :can-login="canLogin" :can-register="canRegister">
        <section
            id="top"
            class="relative flex min-h-[100svh] items-center overflow-hidden bg-navy text-ivory"
        >
            <div
                class="pointer-events-none absolute inset-0"
                style="background:
                    radial-gradient(ellipse 70% 55% at 75% 45%, rgba(46,137,130,0.28), transparent 60%),
                    radial-gradient(ellipse 50% 40% at 15% 80%, rgba(201,162,39,0.14), transparent 55%),
                    linear-gradient(160deg, #0A1F3D 0%, #0E2B53 48%, #12385F 100%);"
            />

            <div
                class="pointer-events-none absolute inset-0 opacity-[0.035]"
                style="background-image:
                    linear-gradient(rgba(255,255,255,0.5) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.5) 1px, transparent 1px);
                    background-size: 64px 64px;"
            />

            <div
                class="pointer-events-none absolute -end-8 top-1/2 hidden w-[28rem] -translate-y-1/2 opacity-[0.16] md:block lg:end-8 lg:w-[34rem] lg:opacity-25"
                aria-hidden="true"
            >
                <ApplicationLogo class="h-full w-full" />
            </div>

            <div class="relative z-10 mx-auto flex w-full max-w-6xl flex-col items-center px-5 pb-20 pt-28 sm:px-8 lg:items-start lg:pb-28 lg:pt-36">
                <div class="mb-8 h-28 w-28 rounded-full bg-white p-1 shadow-[0_24px_50px_-18px_rgba(0,0,0,0.55)] sm:h-32 sm:w-32 lg:mb-10 lg:h-36 lg:w-36">
                    <div class="h-full w-full overflow-hidden rounded-full">
                        <ApplicationLogo />
                    </div>
                </div>

                <p class="text-[0.72rem] font-semibold uppercase tracking-[0.32em] text-[#EAD9AE]">
                    {{ t('brand.tagline') }}
                </p>

                <h1 class="mt-4 max-w-4xl text-center font-display text-[2.9rem] font-semibold leading-[1.05] tracking-tight text-white sm:text-6xl lg:text-start lg:text-[4.4rem]">
                    <span class="block">{{ t('brand.name') }}</span>
                    <span class="mt-1 block text-[#E0BD4A]">{{ t('brand.subtitle') }}</span>
                </h1>

                <p class="mt-5 max-w-xl text-center text-base leading-relaxed text-white/75 sm:text-lg lg:text-start">
                    {{ t('home.hero.lead') }}
                </p>

                <div class="mt-8 flex flex-wrap items-center justify-center gap-3 lg:justify-start">
                    <a
                        href="#schools"
                        class="inline-flex items-center rounded-sm bg-[#C9A227] px-6 py-3 text-[0.7rem] font-semibold uppercase tracking-[0.18em] text-[#0A1F3D] transition hover:bg-[#E0BD4A]"
                    >
                        {{ t('home.hero.cta_schools') }}
                    </a>
                    <a
                        href="#about"
                        class="inline-flex items-center rounded-sm border border-white/30 px-6 py-3 text-[0.7rem] font-semibold uppercase tracking-[0.18em] text-white transition hover:border-[#EAD9AE] hover:text-[#EAD9AE]"
                    >
                        {{ t('home.hero.cta_about') }}
                    </a>
                </div>
            </div>

            <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-ivory to-transparent sm:h-20" />
        </section>

        <section id="about" class="relative z-10 -mt-10 border-b border-navy/10 bg-ivory py-20 sm:py-24">
            <div class="section-shell grid gap-10 lg:grid-cols-2 lg:gap-16">
                <div>
                    <p class="eyebrow">{{ t('home.about.eyebrow') }}</p>
                    <h2 class="mt-3 display-title">{{ t('home.about.title') }}</h2>
                    <div class="gold-rule mt-5" />
                </div>
                <div class="space-y-5">
                    <p class="body-copy">{{ t('home.about.p1') }}</p>
                    <p class="body-copy">{{ t('home.about.p2') }}</p>
                </div>
            </div>
        </section>

        <section class="bg-ivory-warm py-20 sm:py-24">
            <div class="section-shell grid gap-8 md:grid-cols-2">
                <article class="border-s-2 border-gold bg-white/60 px-6 py-2">
                    <p class="eyebrow">{{ t('home.vision.eyebrow') }}</p>
                    <h3 class="mt-3 font-display text-3xl font-semibold text-navy">
                        {{ t('home.vision.title') }}
                    </h3>
                    <p class="mt-4 body-copy">{{ t('home.vision.text') }}</p>
                </article>
                <article class="border-s-2 border-teal bg-white/60 px-6 py-2">
                    <p class="eyebrow">{{ t('home.mission.eyebrow') }}</p>
                    <h3 class="mt-3 font-display text-3xl font-semibold text-navy">
                        {{ t('home.mission.title') }}
                    </h3>
                    <p class="mt-4 body-copy">{{ t('home.mission.text') }}</p>
                </article>
            </div>
        </section>

        <section id="leadership" class="py-20 sm:py-24">
            <div class="section-shell">
                <div class="max-w-2xl">
                    <p class="eyebrow">{{ t('home.leadership.eyebrow') }}</p>
                    <h2 class="mt-3 display-title">{{ t('home.leadership.title') }}</h2>
                    <div class="gold-rule mt-5" />
                </div>

                <div class="mt-12 grid gap-6 lg:grid-cols-2">
                    <article class="bg-navy p-8 text-ivory sm:p-10">
                        <p class="text-[0.68rem] font-semibold uppercase tracking-[0.22em] text-gold-soft">
                            {{ t('home.founder.label') }}
                        </p>
                        <h3 class="mt-4 font-display text-3xl font-semibold">Prof. Dr. Rania</h3>
                        <p class="mt-1 text-sm text-ivory/55">{{ t('home.founder.role') }}</p>
                        <p class="mt-6 text-base leading-relaxed text-ivory/80">
                            {{ t('home.founder.text') }}
                        </p>
                    </article>

                    <article class="border border-navy/10 bg-white p-8 sm:p-10">
                        <p class="text-[0.68rem] font-semibold uppercase tracking-[0.22em] text-teal">
                            {{ t('home.ceo.label') }}
                        </p>
                        <h3 class="mt-4 font-display text-3xl font-semibold text-navy">Dr. Amira</h3>
                        <p class="mt-1 text-sm text-navy-muted">{{ t('home.ceo.role') }}</p>
                        <p class="mt-6 body-copy">{{ t('home.ceo.text') }}</p>
                    </article>
                </div>

                <div class="mt-6 border border-teal/20 bg-teal-mist/50 px-6 py-5 sm:px-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-teal-dark">
                        {{ t('home.advisory.title') }}
                    </p>
                    <p class="mt-2 body-copy">{{ t('home.advisory.text') }}</p>
                </div>
            </div>
        </section>

        <section class="bg-navy py-20 text-ivory sm:py-24">
            <div class="section-shell grid gap-14 lg:grid-cols-2">
                <div>
                    <p class="eyebrow text-teal-soft">{{ t('home.objectives.eyebrow') }}</p>
                    <h2 class="mt-3 font-display text-4xl font-semibold sm:text-5xl">
                        {{ t('home.objectives.title') }}
                    </h2>
                    <ul class="mt-8 space-y-4">
                        <li
                            v-for="(item, index) in objectives"
                            :key="index"
                            class="flex gap-4 border-t border-white/10 pt-4 text-ivory/80"
                        >
                            <span class="font-display text-xl text-gold">0{{ index + 1 }}</span>
                            <span>{{ item }}</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <p class="eyebrow text-gold-soft">{{ t('home.achievements.eyebrow') }}</p>
                    <h2 class="mt-3 font-display text-4xl font-semibold sm:text-5xl">
                        {{ t('home.achievements.title') }}
                    </h2>
                    <div class="mt-8 grid grid-cols-2 gap-4">
                        <div
                            v-for="item in achievements"
                            :key="item.label"
                            class="border border-white/10 bg-white/[0.04] p-5"
                        >
                            <p class="font-display text-4xl font-semibold text-gold-soft">
                                {{ item.value }}
                            </p>
                            <p class="mt-2 text-xs uppercase tracking-[0.16em] text-ivory/60">
                                {{ item.label }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="schools" class="py-20 sm:py-24">
            <div class="section-shell">
                <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-end">
                    <div class="max-w-2xl">
                        <p class="eyebrow">{{ t('home.schools.eyebrow') }}</p>
                        <h2 class="mt-3 display-title">{{ t('home.schools.title') }}</h2>
                        <div class="gold-rule mt-5" />
                    </div>
                    <Link
                        :href="route('schools.index')"
                        class="text-sm font-semibold text-teal transition hover:text-navy"
                    >
                        {{ t('home.schools.view_all') }}
                    </Link>
                </div>

                <div class="mt-12 grid gap-4 md:grid-cols-2">
                    <Link
                        v-for="school in schools"
                        :key="school.code"
                        :href="route('schools.show', school.slug)"
                        class="group border border-navy/10 bg-white p-6 transition duration-300 hover:border-teal/50 hover:shadow-[0_24px_50px_-36px_rgba(14,43,83,0.55)] sm:p-7"
                    >
                        <div class="flex items-start gap-4">
                            <span
                                class="flex h-11 w-11 shrink-0 items-center justify-center border border-gold/40 font-display text-lg text-navy transition group-hover:bg-navy group-hover:text-gold-soft"
                            >
                                {{ school.code }}
                            </span>
                            <div>
                                <h3 class="font-display text-2xl font-semibold text-navy">
                                    {{ school.name }}
                                </h3>
                                <p class="mt-2 text-sm leading-relaxed text-navy-muted">
                                    {{ school.blurb }}
                                </p>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <section id="programs" class="bg-ivory-warm py-20 sm:py-24">
            <div class="section-shell grid gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:gap-14">
                <div>
                    <p class="eyebrow">{{ t('home.programs.eyebrow') }}</p>
                    <h2 class="mt-3 display-title">{{ t('home.programs.title') }}</h2>
                    <div class="gold-rule mt-5" />
                    <p class="mt-5 body-copy">{{ t('home.programs.text') }}</p>
                    <div class="mt-7 space-y-3 text-sm text-navy-muted">
                        <p>
                            <span class="font-semibold text-navy">{{ t('home.programs.director') }}</span>
                            · {{ t('home.programs.director_value') }}
                        </p>
                        <p>
                            <span class="font-semibold text-navy">{{ t('home.programs.speakers') }}</span>
                            · {{ t('home.programs.speakers_value') }}
                        </p>
                        <p>
                            <span class="font-semibold text-navy">{{ t('home.programs.credentials') }}</span>
                            · {{ t('home.programs.credentials_value') }}
                        </p>
                    </div>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <div
                        v-for="item in programItems"
                        :key="item"
                        class="border border-navy/10 bg-white px-5 py-5"
                    >
                        <p class="font-display text-xl font-semibold text-navy">{{ item }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 sm:py-24">
            <div class="section-shell">
                <div class="max-w-2xl">
                    <p class="eyebrow">{{ t('home.services.eyebrow') }}</p>
                    <h2 class="mt-3 display-title">{{ t('home.services.title') }}</h2>
                    <div class="gold-rule mt-5" />
                </div>
                <div class="mt-10 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <article
                        v-for="service in services"
                        :key="service.title"
                        class="border-t-2 border-teal bg-white p-6"
                    >
                        <h3 class="font-display text-2xl font-semibold text-navy">
                            {{ service.title }}
                        </h3>
                        <p class="mt-3 text-sm leading-relaxed text-navy-muted">
                            {{ service.text }}
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section class="border-y border-navy/10 bg-white py-20 sm:py-24">
            <div class="section-shell grid gap-12 lg:grid-cols-2">
                <div>
                    <p class="eyebrow">{{ t('home.trust.eyebrow') }}</p>
                    <h2 class="mt-3 display-title">{{ t('home.trust.title') }}</h2>
                    <p class="mt-5 body-copy">{{ t('home.trust.text') }}</p>
                </div>
                <div>
                    <p class="eyebrow">{{ t('home.alliance.eyebrow') }}</p>
                    <h2 class="mt-3 display-title">{{ t('home.alliance.title') }}</h2>
                    <p class="mt-5 body-copy">{{ t('home.alliance.text') }}</p>
                    <div class="mt-7 grid grid-cols-2 gap-3 sm:grid-cols-3">
                        <div
                            v-for="n in 6"
                            :key="n"
                            class="flex h-14 items-center justify-center border border-dashed border-navy/15 bg-ivory text-[0.65rem] uppercase tracking-[0.14em] text-navy-muted"
                        >
                            {{ t('home.alliance.partner', { n }) }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="news" class="py-20 sm:py-24">
            <div class="section-shell">
                <div class="max-w-2xl">
                    <p class="eyebrow">{{ t('home.news.eyebrow') }}</p>
                    <h2 class="mt-3 display-title">{{ t('home.news.title') }}</h2>
                    <div class="gold-rule mt-5" />
                </div>

                <div class="mt-10 divide-y divide-navy/10 border-y border-navy/10">
                    <article
                        v-for="item in news"
                        :key="item.title"
                        class="grid gap-2 py-6 sm:grid-cols-[110px_1fr_130px] sm:items-center sm:gap-4"
                    >
                        <span class="text-[0.68rem] font-semibold uppercase tracking-[0.18em] text-teal">
                            {{ item.tag }}
                        </span>
                        <h3 class="font-display text-2xl font-semibold text-navy">
                            {{ item.title }}
                        </h3>
                        <p class="text-sm text-navy-muted sm:text-end">{{ item.date }}</p>
                    </article>
                </div>
            </div>
        </section>

        <section id="contact" class="bg-navy py-20 text-ivory sm:py-24">
            <div class="section-shell grid gap-10 lg:grid-cols-[1fr_1.05fr] lg:gap-14">
                <div>
                    <p class="eyebrow text-teal-soft">{{ t('home.contact.eyebrow') }}</p>
                    <h2 class="mt-3 font-display text-4xl font-semibold sm:text-5xl">
                        {{ t('home.contact.title') }}
                    </h2>
                    <p class="mt-5 max-w-md text-base leading-relaxed text-ivory/65">
                        {{ t('home.contact.text') }}
                    </p>
                    <div class="mt-7 space-y-2 text-sm text-ivory/70">
                        <p>admissions@vertex-academy.com</p>
                        <p>experts@vertex-academy.com</p>
                    </div>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="mt-8 inline-flex rounded-sm bg-gold px-6 py-3 text-[0.7rem] font-semibold uppercase tracking-[0.18em] text-navy-deep transition hover:bg-gold-bright"
                    >
                        {{ t('home.contact.create_account') }}
                    </Link>
                </div>

                <form class="grid gap-4 border border-white/10 bg-white/[0.04] p-6 sm:grid-cols-2 sm:p-8" @submit.prevent>
                    <label class="block">
                        <span class="text-[0.65rem] uppercase tracking-[0.16em] text-ivory/50">{{ t('home.contact.name') }}</span>
                        <input
                            type="text"
                            class="mt-2 w-full border-0 border-b border-white/20 bg-transparent px-0 py-2 text-ivory placeholder:text-ivory/25 focus:border-gold focus:ring-0"
                            :placeholder="t('home.contact.name_ph')"
                        />
                    </label>
                    <label class="block">
                        <span class="text-[0.65rem] uppercase tracking-[0.16em] text-ivory/50">{{ t('home.contact.email') }}</span>
                        <input
                            type="email"
                            class="mt-2 w-full border-0 border-b border-white/20 bg-transparent px-0 py-2 text-ivory placeholder:text-ivory/25 focus:border-gold focus:ring-0"
                            :placeholder="t('home.contact.email_ph')"
                        />
                    </label>
                    <label class="block sm:col-span-2">
                        <span class="text-[0.65rem] uppercase tracking-[0.16em] text-ivory/50">{{ t('home.contact.message') }}</span>
                        <textarea
                            rows="4"
                            class="mt-2 w-full border-0 border-b border-white/20 bg-transparent px-0 py-2 text-ivory placeholder:text-ivory/25 focus:border-gold focus:ring-0"
                            :placeholder="t('home.contact.message_ph')"
                        />
                    </label>
                    <div class="sm:col-span-2">
                        <button
                            type="submit"
                            class="rounded-sm border border-gold/45 px-6 py-3 text-[0.7rem] font-semibold uppercase tracking-[0.18em] text-gold-soft transition hover:bg-gold hover:text-navy-deep"
                        >
                            {{ t('home.contact.send') }}
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </MarketingLayout>
</template>
