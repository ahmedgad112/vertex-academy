<script setup>
import PortalLayout from '@/Layouts/PortalLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    course: Object,
});

const links = computed(() => [
    { label: 'My Desk', href: route('student.dashboard'), match: 'student.dashboard' },
    { label: 'Browse Courses', href: route('student.courses.index'), match: 'student.courses.*' },
    { label: 'My Library', href: route('student.library'), match: 'student.library' },
    { label: 'Profile', href: route('profile.edit'), match: 'profile.*' },
]);

const form = useForm({});

const enroll = () => {
    form.post(route('student.courses.enroll', props.course.slug));
};
</script>

<template>
    <Head :title="course.title" />

    <PortalLayout portal="student" title="Student Portal" :links="links">
        <template #header>
            <div>
                <Link :href="route('student.courses.index')" class="text-xs uppercase tracking-[0.16em] text-teal">← Catalog</Link>
                <h2 class="mt-2 font-display text-3xl font-semibold text-navy">{{ course.title }}</h2>
            </div>
        </template>

        <div class="px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-[1.3fr_0.7fr]">
                <section class="border border-navy/10 bg-white p-6">
                    <div class="flex flex-wrap gap-2">
                        <span class="rounded-sm bg-teal-mist px-2 py-1 text-xs font-semibold text-teal-dark">{{ course.type_label }}</span>
                        <span v-if="course.level" class="rounded-sm border border-navy/15 px-2 py-1 text-xs text-navy">{{ course.level }}</span>
                    </div>
                    <p class="mt-4 text-navy-muted">{{ course.summary }}</p>
                    <p class="mt-4 whitespace-pre-line text-sm leading-relaxed text-navy">{{ course.description }}</p>
                    <p class="mt-6 text-sm text-navy-muted">Instructor · {{ course.instructor?.name }}</p>
                </section>

                <aside class="border border-navy/10 bg-navy p-6 text-ivory">
                    <p class="text-xs uppercase tracking-[0.18em] text-gold-soft">Access</p>
                    <p class="mt-3 font-display text-4xl font-semibold">{{ course.price_label }}</p>
                    <p class="mt-2 text-sm text-ivory/70">
                        {{ course.requires_payment ? 'Pay once to unlock forever in your library.' : 'Free enrollment unlocks instantly.' }}
                    </p>

                    <div class="mt-6">
                        <Link
                            v-if="course.enrollment?.unlocked"
                            :href="route('student.library')"
                            class="inline-flex rounded-sm bg-gold px-4 py-2 text-xs font-semibold uppercase tracking-[0.16em] text-navy-deep"
                        >
                            Open in library
                        </Link>
                        <PrimaryButton
                            v-else
                            class="w-full justify-center"
                            :disabled="form.processing"
                            @click="enroll"
                        >
                            {{ course.requires_payment ? 'Enroll & checkout' : 'Add to library free' }}
                        </PrimaryButton>
                    </div>
                </aside>
            </div>
        </div>
    </PortalLayout>
</template>
