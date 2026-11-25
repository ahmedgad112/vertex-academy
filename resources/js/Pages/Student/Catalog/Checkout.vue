<script setup>
import PortalLayout from '@/Layouts/PortalLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    course: Object,
});

const page = usePage();

const links = computed(() => [
    { label: 'My Desk', href: route('student.dashboard'), match: 'student.dashboard' },
    { label: 'Browse Courses', href: route('student.courses.index'), match: 'student.courses.*' },
    { label: 'My Library', href: route('student.library'), match: 'student.library' },
    { label: 'Profile', href: route('profile.edit'), match: 'profile.*' },
]);

const form = useForm({});

const pay = () => {
    form.post(route('student.courses.pay', props.course.slug));
};
</script>

<template>
    <Head title="Checkout" />

    <PortalLayout portal="student" title="Student Portal" :links="links">
        <template #header>
            <h2 class="font-display text-3xl font-semibold text-navy">Checkout</h2>
        </template>

        <div class="px-4 py-8 sm:px-6 lg:px-8">
            <div v-if="page.props.flash?.success" class="mb-5 border border-teal/30 bg-teal-mist px-4 py-3 text-sm text-teal-dark">
                {{ page.props.flash.success }}
            </div>

            <div class="mx-auto max-w-xl border border-navy/10 bg-white p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-teal">{{ course.type_label }}</p>
                <h3 class="mt-2 font-display text-3xl font-semibold text-navy">{{ course.title }}</h3>
                <p class="mt-3 text-sm text-navy-muted">{{ course.summary }}</p>

                <div class="mt-6 flex items-center justify-between border-t border-navy/10 pt-4">
                    <span class="text-navy-muted">Total</span>
                    <span class="font-display text-3xl font-semibold text-navy">{{ course.price_label }}</span>
                </div>

                <p class="mt-4 text-xs text-navy-muted">
                    Demo checkout: confirming payment unlocks the course in your library (Udemy-style access).
                </p>

                <div class="mt-6 flex items-center justify-between gap-3">
                    <Link :href="route('student.courses.show', course.slug)" class="text-sm underline">Back</Link>
                    <PrimaryButton :disabled="form.processing" @click="pay">
                        Pay & unlock
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </PortalLayout>
</template>
