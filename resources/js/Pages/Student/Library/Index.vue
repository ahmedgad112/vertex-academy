<script setup>
import PortalLayout from '@/Layouts/PortalLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    library: Array,
    pending: Array,
});

const page = usePage();

const links = computed(() => [
    { label: 'My Desk', href: route('student.dashboard'), match: 'student.dashboard' },
    { label: 'Browse Courses', href: route('student.courses.index'), match: 'student.courses.*' },
    { label: 'My Library', href: route('student.library'), match: 'student.library' },
    { label: 'Profile', href: route('profile.edit'), match: 'profile.*' },
]);

const payForm = useForm({});

const continuePayment = (slug) => {
    payForm.post(route('student.courses.pay', slug));
};
</script>

<template>
    <Head title="My Library" />

    <PortalLayout portal="student" title="Student Portal" :links="links">
        <template #header>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-teal">Learning</p>
                <h2 class="mt-1 font-display text-3xl font-semibold text-navy">My library</h2>
            </div>
        </template>

        <div class="px-4 py-8 sm:px-6 lg:px-8">
            <div v-if="page.props.flash?.success" class="mb-5 border border-teal/30 bg-teal-mist px-4 py-3 text-sm text-teal-dark">
                {{ page.props.flash.success }}
            </div>

            <section>
                <h3 class="font-display text-2xl font-semibold text-navy">Unlocked courses</h3>
                <div v-if="library.length" class="mt-4 grid gap-4 md:grid-cols-2">
                    <article v-for="course in library" :key="course.id" class="border border-navy/10 bg-white p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-teal">{{ course.type_label }}</p>
                        <h4 class="mt-2 font-display text-2xl font-semibold text-navy">{{ course.title }}</h4>
                        <p class="mt-2 text-sm text-navy-muted">Progress · {{ course.enrollment?.progress_percent || 0 }}%</p>
                        <Link :href="route('student.courses.show', course.slug)" class="mt-4 inline-block text-xs font-semibold uppercase tracking-[0.12em] text-teal">
                            Continue learning →
                        </Link>
                    </article>
                </div>
                <p v-else class="mt-3 text-sm text-navy-muted">
                    Your library is empty.
                    <Link :href="route('student.courses.index')" class="text-teal underline">Browse courses</Link>
                </p>
            </section>

            <section v-if="pending.length" class="mt-10">
                <h3 class="font-display text-2xl font-semibold text-navy">Awaiting payment</h3>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <article v-for="course in pending" :key="course.id" class="border border-gold/30 bg-white p-5">
                        <h4 class="font-display text-xl font-semibold text-navy">{{ course.title }}</h4>
                        <p class="mt-2 text-sm text-navy-muted">{{ course.price_label }}</p>
                        <button
                            type="button"
                            class="mt-4 text-xs font-semibold uppercase tracking-[0.12em] text-gold-muted"
                            :disabled="payForm.processing"
                            @click="continuePayment(course.slug)"
                        >
                            Complete payment →
                        </button>
                    </article>
                </div>
            </section>
        </div>
    </PortalLayout>
</template>
