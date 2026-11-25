<script setup>
import PortalLayout from '@/Layouts/PortalLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    courses: Object,
    types: Array,
});

const page = usePage();

const links = computed(() => [
    { label: 'Instructor Desk', href: route('instructor.dashboard'), match: 'instructor.dashboard' },
    { label: 'My Courses', href: route('instructor.courses.index'), match: 'instructor.courses.*' },
    { label: 'Profile', href: route('profile.edit'), match: 'profile.*' },
]);
</script>

<template>
    <Head title="My Courses · Instructor" />

    <PortalLayout portal="instructor" title="Instructor Portal" :links="links">
        <template #header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <h2 class="font-display text-3xl font-semibold text-navy">My courses</h2>
                <Link :href="route('instructor.courses.create')" class="rounded-sm bg-navy px-4 py-2 text-xs font-semibold uppercase tracking-[0.16em] text-ivory">
                    New course
                </Link>
            </div>
        </template>

        <div class="px-4 py-8 sm:px-6 lg:px-8">
            <div v-if="page.props.flash?.success" class="mb-5 border border-teal/30 bg-teal-mist px-4 py-3 text-sm text-teal-dark">
                {{ page.props.flash.success }}
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <article v-for="course in courses.data" :key="course.id" class="border border-navy/10 bg-white p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-teal">{{ course.type_label }}</p>
                    <h3 class="mt-2 font-display text-2xl font-semibold text-navy">{{ course.title }}</h3>
                    <p class="mt-2 text-sm text-navy-muted">{{ course.summary }}</p>
                    <div class="mt-4 flex items-center justify-between text-sm">
                        <span>{{ course.price_label }}</span>
                        <span>{{ course.students_count || 0 }} students</span>
                    </div>
                    <Link :href="route('instructor.courses.edit', course.id)" class="mt-4 inline-block text-xs font-semibold uppercase tracking-[0.12em] text-teal">
                        Edit →
                    </Link>
                </article>
            </div>
        </div>
    </PortalLayout>
</template>
