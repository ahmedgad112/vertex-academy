<script setup>
import MarketingLayout from '@/Layouts/MarketingLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    school: Object,
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head :title="`School of ${school.name}`" />

    <MarketingLayout :can-login="canLogin" :can-register="canRegister">
        <section class="bg-navy pb-16 pt-32 text-ivory">
            <div class="section-shell">
                <Link
                    :href="route('schools.index')"
                    class="text-xs uppercase tracking-[0.18em] text-teal-soft hover:text-gold-soft"
                >
                    ← All schools
                </Link>
                <h1 class="mt-5 font-display text-5xl font-semibold">
                    Vertex School of {{ school.name }}
                </h1>
                <p class="mt-4 max-w-2xl text-ivory/70">{{ school.blurb }}</p>
            </div>
        </section>

        <section class="py-20">
            <div class="section-shell grid gap-10 lg:grid-cols-[0.9fr_1.1fr]">
                <div>
                    <p class="eyebrow">Divisions</p>
                    <h2 class="mt-4 display-title">Program pathways</h2>
                    <div class="gold-rule mt-6" />
                </div>
                <ul class="space-y-3">
                    <li
                        v-for="division in school.divisions"
                        :key="division"
                        class="border border-navy/10 bg-white px-5 py-4 font-display text-xl text-navy"
                    >
                        {{ division }}
                    </li>
                </ul>
            </div>
        </section>

        <section class="border-t border-navy/10 bg-ivory-warm py-16">
            <div class="section-shell">
                <p class="eyebrow">Enrollment path</p>
                <h2 class="mt-4 display-title">From curriculum to certification</h2>
                <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="step in [
                            'About & ILOs',
                            'Pre-requisites',
                            'Course Duration',
                            'Credentials',
                            'Certifications',
                            'Enrollment & Payment',
                        ]"
                        :key="step"
                        class="border border-navy/10 bg-white px-5 py-5"
                    >
                        <p class="font-display text-xl font-semibold text-navy">{{ step }}</p>
                    </div>
                </div>
            </div>
        </section>
    </MarketingLayout>
</template>
