<script setup>
import MarketingLayout from '@/Layouts/MarketingLayout.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

const schools = [
    {
        code: '01',
        slug: 'laboratory-medicine',
        name: 'Laboratory Medicine',
        blurb: 'Clinical diagnostics, microbiology, hematology, molecular biology, and laboratory excellence.',
        divisions: [
            'Laboratory Quality Management & Accreditation',
            'Clinical & Diagnostic Microbiology',
            'Clinical Parasitology',
            'Hematology & Transfusion Medicine',
            'Molecular Biology & Diagnostics',
        ],
    },
    {
        code: '02',
        slug: 'quality-patient-safety-accreditation',
        name: 'Quality, Patient Safety & Accreditation',
        blurb: 'Systems that protect patients and elevate institutional standards across healthcare.',
        divisions: ['Quality Systems', 'Patient Safety', 'Accreditation Pathways'],
    },
    {
        code: '03',
        slug: 'healthcare-informatics-digital-health',
        name: 'Healthcare Informatics & Digital Health',
        blurb: 'Data, digital workflows, and intelligent systems for modern care delivery.',
        divisions: ['Health Informatics', 'Digital Health', 'Clinical Decision Support'],
    },
    {
        code: '04',
        slug: 'management-leadership-governance',
        name: 'Management, Leadership & Governance',
        blurb: 'Leadership craft for healthcare institutions navigating complexity and change.',
        divisions: ['Healthcare Management', 'Leadership', 'Governance'],
    },
];

const objectives = [
    'Advance scientific competence through rigorous, practice-led curricula.',
    'Build internationally aligned credentials for healthcare professionals.',
    'Bridge classic academic depth with intelligent, AI-aware learning.',
    'Support institutions with accreditation expertise and technical guidance.',
];

const achievements = [
    { value: '4', label: 'Specialized Schools' },
    { value: '20+', label: 'Program Tracks' },
    { value: 'Global', label: 'Advisory Network' },
    { value: 'AI+', label: 'Learning Edge' },
];

const services = [
    {
        title: 'Hands-on Workshops',
        text: 'Intensive practical sessions led by domain experts.',
    },
    {
        title: 'Experts Free Webinars',
        text: 'Open knowledge sessions with international faculty.',
    },
    {
        title: 'Books, Guidelines & Materials',
        text: 'Curated scientific resources for continuous learning.',
    },
    {
        title: 'Accreditation Technical Support',
        text: 'Ask the experts — guidance for institutional readiness.',
    },
];

const news = [
    {
        tag: 'Program',
        title: 'Clinical & Diagnostic Microbiology cohort opens enrollment',
        date: 'November 2026',
    },
    {
        tag: 'Webinar',
        title: 'Laboratory quality systems in the age of digital health',
        date: 'December 2026',
    },
    {
        tag: 'Academy',
        title: 'International advisory board expands regional presence',
        date: 'January 2027',
    },
];
</script>

<template>
    <Head title="Home" />

    <MarketingLayout :can-login="canLogin" :can-register="canRegister">
        <!-- Hero: one composition -->
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

            <!-- Seal watermark -->
            <div
                class="pointer-events-none absolute -right-8 top-1/2 hidden w-[28rem] -translate-y-1/2 opacity-[0.16] md:block lg:right-8 lg:w-[34rem] lg:opacity-25"
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
                    Educate · Innovate · Excel
                </p>

                <h1 class="mt-4 max-w-4xl text-center font-display text-[2.9rem] font-semibold leading-[1.05] tracking-tight text-white sm:text-6xl lg:text-left lg:text-[4.4rem]">
                    <span class="block">Vertex</span>
                    <span class="mt-1 block text-[#E0BD4A]">International Academy</span>
                </h1>

                <p class="mt-5 max-w-xl text-center text-base leading-relaxed text-white/75 sm:text-lg lg:text-left">
                    Classic academic rigor for healthcare professionals —
                    with a precise, intelligent edge for the age ahead.
                </p>

                <div class="mt-8 flex flex-wrap items-center justify-center gap-3 lg:justify-start">
                    <a
                        href="#schools"
                        class="inline-flex items-center rounded-sm bg-[#C9A227] px-6 py-3 text-[0.7rem] font-semibold uppercase tracking-[0.18em] text-[#0A1F3D] transition hover:bg-[#E0BD4A]"
                    >
                        Explore Schools
                    </a>
                    <a
                        href="#about"
                        class="inline-flex items-center rounded-sm border border-white/30 px-6 py-3 text-[0.7rem] font-semibold uppercase tracking-[0.18em] text-white transition hover:border-[#EAD9AE] hover:text-[#EAD9AE]"
                    >
                        Who We Are
                    </a>
                </div>
            </div>

            <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-ivory to-transparent sm:h-20" />
        </section>

        <!-- Who We Are -->
        <section id="about" class="relative z-10 -mt-10 border-b border-navy/10 bg-ivory py-20 sm:py-24">
            <div class="section-shell grid gap-10 lg:grid-cols-2 lg:gap-16">
                <div>
                    <p class="eyebrow">Who We Are</p>
                    <h2 class="mt-3 display-title">What We Do</h2>
                    <div class="gold-rule mt-5" />
                </div>
                <div class="space-y-5">
                    <p class="body-copy">
                        Vertex International Academy is a specialized learning institution
                        dedicated to elevating healthcare practice through structured schools,
                        rigorous programs, and internationally minded faculty.
                    </p>
                    <p class="body-copy">
                        We educate clinicians, laboratory professionals, quality leaders, and
                        digital health practitioners — combining scholarly depth with applied
                        competence for institutions that refuse to stand still.
                    </p>
                </div>
            </div>
        </section>

        <!-- Vision & Mission -->
        <section class="bg-ivory-warm py-20 sm:py-24">
            <div class="section-shell grid gap-8 md:grid-cols-2">
                <article class="border-l-2 border-gold bg-white/60 py-2 pl-6 pr-2">
                    <p class="eyebrow">Vision</p>
                    <h3 class="mt-3 font-display text-3xl font-semibold text-navy">
                        A global reference in healthcare education
                    </h3>
                    <p class="mt-4 body-copy">
                        To shape professionals who lead laboratories, quality systems, digital
                        health, and governance with clarity, ethics, and scientific excellence.
                    </p>
                </article>
                <article class="border-l-2 border-teal bg-white/60 py-2 pl-6 pr-2">
                    <p class="eyebrow">Mission</p>
                    <h3 class="mt-3 font-display text-3xl font-semibold text-navy">
                        Educate. Innovate. Excel.
                    </h3>
                    <p class="mt-4 body-copy">
                        Deliver transformative programs, open expert knowledge, and accreditation
                        support that move individuals and institutions forward — with classical
                        discipline and contemporary intelligence.
                    </p>
                </article>
            </div>
        </section>

        <!-- Leadership -->
        <section id="leadership" class="py-20 sm:py-24">
            <div class="section-shell">
                <div class="max-w-2xl">
                    <p class="eyebrow">Leadership</p>
                    <h2 class="mt-3 display-title">Voices of the Academy</h2>
                    <div class="gold-rule mt-5" />
                </div>

                <div class="mt-12 grid gap-6 lg:grid-cols-2">
                    <article class="bg-navy p-8 text-ivory sm:p-10">
                        <p class="text-[0.68rem] font-semibold uppercase tracking-[0.22em] text-gold-soft">
                            Founder's Message
                        </p>
                        <h3 class="mt-4 font-display text-3xl font-semibold">Prof. Dr. Rania</h3>
                        <p class="mt-1 text-sm text-ivory/55">Chairman</p>
                        <p class="mt-6 text-base leading-relaxed text-ivory/80">
                            “Vertex was founded on a simple conviction: excellence in healthcare
                            begins with disciplined learning. We preserve the dignity of classical
                            scholarship while preparing minds for an intelligent future.”
                        </p>
                    </article>

                    <article class="border border-navy/10 bg-white p-8 sm:p-10">
                        <p class="text-[0.68rem] font-semibold uppercase tracking-[0.22em] text-teal">
                            CEO's Message
                        </p>
                        <h3 class="mt-4 font-display text-3xl font-semibold text-navy">Dr. Amira</h3>
                        <p class="mt-1 text-sm text-navy-muted">Chief Executive Officer</p>
                        <p class="mt-6 body-copy">
                            “Our academy is built as a living system — schools, programs, workshops,
                            and expert support working together so every learner and partner
                            institution can excel with confidence.”
                        </p>
                    </article>
                </div>

                <div class="mt-6 border border-teal/20 bg-teal-mist/50 px-6 py-5 sm:px-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-teal-dark">
                        International Advisory Board
                    </p>
                    <p class="mt-2 body-copy">
                        Guided by scholars and practitioners who keep our curricula aligned with
                        global standards and emerging science.
                    </p>
                </div>
            </div>
        </section>

        <!-- Objectives & Achievements -->
        <section class="bg-navy py-20 text-ivory sm:py-24">
            <div class="section-shell grid gap-14 lg:grid-cols-2">
                <div>
                    <p class="eyebrow text-teal-soft">Our Objectives</p>
                    <h2 class="mt-3 font-display text-4xl font-semibold sm:text-5xl">
                        Purposeful by design
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
                    <p class="eyebrow text-gold-soft">Our Achievements</p>
                    <h2 class="mt-3 font-display text-4xl font-semibold sm:text-5xl">
                        Progress with presence
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

        <!-- Schools -->
        <section id="schools" class="py-20 sm:py-24">
            <div class="section-shell">
                <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-end">
                    <div class="max-w-2xl">
                        <p class="eyebrow">Our Schools</p>
                        <h2 class="mt-3 display-title">
                            Four schools. One academic spine.
                        </h2>
                        <div class="gold-rule mt-5" />
                    </div>
                    <Link
                        :href="route('schools.index')"
                        class="text-sm font-semibold text-teal transition hover:text-navy"
                    >
                        View all schools →
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

        <!-- Program spotlight -->
        <section id="programs" class="bg-ivory-warm py-20 sm:py-24">
            <div class="section-shell grid gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:gap-14">
                <div>
                    <p class="eyebrow">Program Spotlight</p>
                    <h2 class="mt-3 display-title">
                        Clinical & Diagnostic Microbiology
                    </h2>
                    <div class="gold-rule mt-5" />
                    <p class="mt-5 body-copy">
                        From scientific direction to enrollment — a complete academic journey
                        with curriculum depth, credentials, and practitioner-led teaching.
                    </p>
                    <div class="mt-7 space-y-3 text-sm text-navy-muted">
                        <p><span class="font-semibold text-navy">Scientific Director</span> · Faculty-led oversight</p>
                        <p><span class="font-semibold text-navy">Board of Speakers</span> · International experts</p>
                        <p><span class="font-semibold text-navy">Credentials</span> · Certifications & pathways</p>
                    </div>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <div
                        v-for="item in [
                            'About & ILOs',
                            'Pre-requisites',
                            'Course Duration',
                            'Comprehensive Curriculum',
                            'Certifications',
                            'Enrollment & Payment',
                        ]"
                        :key="item"
                        class="border border-navy/10 bg-white px-5 py-5"
                    >
                        <p class="font-display text-xl font-semibold text-navy">{{ item }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services -->
        <section class="py-20 sm:py-24">
            <div class="section-shell">
                <div class="max-w-2xl">
                    <p class="eyebrow">Beyond the classroom</p>
                    <h2 class="mt-3 display-title">Academy services</h2>
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

        <!-- Accreditations & Partners -->
        <section class="border-y border-navy/10 bg-white py-20 sm:py-24">
            <div class="section-shell grid gap-12 lg:grid-cols-2">
                <div>
                    <p class="eyebrow">Trust</p>
                    <h2 class="mt-3 display-title">International Accreditations</h2>
                    <p class="mt-5 body-copy">
                        Pathways aligned with international quality expectations — preparing
                        professionals and institutions for recognized excellence.
                    </p>
                </div>
                <div>
                    <p class="eyebrow">Alliance</p>
                    <h2 class="mt-3 display-title">Success Partners</h2>
                    <p class="mt-5 body-copy">
                        Academic, clinical, and quality partners who share our commitment to
                        elevating healthcare education.
                    </p>
                    <div class="mt-7 grid grid-cols-2 gap-3 sm:grid-cols-3">
                        <div
                            v-for="n in 6"
                            :key="n"
                            class="flex h-14 items-center justify-center border border-dashed border-navy/15 bg-ivory text-[0.65rem] uppercase tracking-[0.14em] text-navy-muted"
                        >
                            Partner {{ n }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- News -->
        <section id="news" class="py-20 sm:py-24">
            <div class="section-shell">
                <div class="max-w-2xl">
                    <p class="eyebrow">Latest News</p>
                    <h2 class="mt-3 display-title">From the academy desk</h2>
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
                        <p class="text-sm text-navy-muted sm:text-right">{{ item.date }}</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- Contact -->
        <section id="contact" class="bg-navy py-20 text-ivory sm:py-24">
            <div class="section-shell grid gap-10 lg:grid-cols-[1fr_1.05fr] lg:gap-14">
                <div>
                    <p class="eyebrow text-teal-soft">Contact Us</p>
                    <h2 class="mt-3 font-display text-4xl font-semibold sm:text-5xl">
                        Begin your Vertex journey
                    </h2>
                    <p class="mt-5 max-w-md text-base leading-relaxed text-ivory/65">
                        Enrollment guidance, partnerships, workshops, or accreditation support.
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
                        Create Account
                    </Link>
                </div>

                <form class="grid gap-4 border border-white/10 bg-white/[0.04] p-6 sm:grid-cols-2 sm:p-8" @submit.prevent>
                    <label class="block">
                        <span class="text-[0.65rem] uppercase tracking-[0.16em] text-ivory/50">Name</span>
                        <input
                            type="text"
                            class="mt-2 w-full border-0 border-b border-white/20 bg-transparent px-0 py-2 text-ivory placeholder:text-ivory/25 focus:border-gold focus:ring-0"
                            placeholder="Your full name"
                        />
                    </label>
                    <label class="block">
                        <span class="text-[0.65rem] uppercase tracking-[0.16em] text-ivory/50">Email</span>
                        <input
                            type="email"
                            class="mt-2 w-full border-0 border-b border-white/20 bg-transparent px-0 py-2 text-ivory placeholder:text-ivory/25 focus:border-gold focus:ring-0"
                            placeholder="you@example.com"
                        />
                    </label>
                    <label class="block sm:col-span-2">
                        <span class="text-[0.65rem] uppercase tracking-[0.16em] text-ivory/50">Message</span>
                        <textarea
                            rows="4"
                            class="mt-2 w-full border-0 border-b border-white/20 bg-transparent px-0 py-2 text-ivory placeholder:text-ivory/25 focus:border-gold focus:ring-0"
                            placeholder="How can the academy help?"
                        />
                    </label>
                    <div class="sm:col-span-2">
                        <button
                            type="submit"
                            class="rounded-sm border border-gold/45 px-6 py-3 text-[0.7rem] font-semibold uppercase tracking-[0.18em] text-gold-soft transition hover:bg-gold hover:text-navy-deep"
                        >
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </MarketingLayout>
</template>
