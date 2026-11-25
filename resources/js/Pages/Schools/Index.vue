<script setup>
import MarketingLayout from '@/Layouts/MarketingLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    schools: Array,
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="Our Schools" />

    <MarketingLayout :can-login="canLogin" :can-register="canRegister">
        <section class="bg-navy pb-16 pt-32 text-ivory">
            <div class="section-shell">
                <p class="eyebrow text-teal-soft">Academic Structure</p>
                <h1 class="mt-4 font-display text-5xl font-semibold">Our Schools</h1>
                <p class="mt-4 max-w-2xl text-ivory/70">
                    Four specialized schools forming the academic spine of Vertex International Academy.
                </p>
            </div>
        </section>

        <section class="py-20">
            <div class="section-shell space-y-5">
                <Link
                    v-for="(school, index) in schools"
                    :key="school.slug"
                    :href="route('schools.show', school.slug)"
                    class="block border border-navy/10 bg-white p-6 transition hover:border-teal/40 sm:p-8"
                >
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold">
                        School 0{{ index + 1 }}
                    </p>
                    <h2 class="mt-3 font-display text-3xl font-semibold text-navy">
                        Vertex School of {{ school.name }}
                    </h2>
                    <p class="mt-3 max-w-3xl body-copy">{{ school.blurb }}</p>
                </Link>
            </div>
        </section>
    </MarketingLayout>
</template>
