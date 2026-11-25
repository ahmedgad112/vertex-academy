<script setup>
import PortalLayout from '@/Layouts/PortalLayout.vue';
import { useLang } from '@/Composables/useLang';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    instructor: Object,
    stats: Object,
    courses: Array,
});

const { t } = useLang();

const links = computed(() => [
    { label: t('portal.instructor_desk'), href: route('instructor.dashboard'), match: 'instructor.dashboard' },
    { label: t('portal.my_courses'), href: route('instructor.courses.index'), match: 'instructor.courses.*' },
    { label: t('portal.profile'), href: route('profile.edit'), match: 'profile.*' },
]);
</script>

<template>
    <Head :title="t('portal.instructor')" />

    <PortalLayout portal="instructor" :title="t('portal.instructor')" :links="links">
        <template #header>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-teal">Faculty desk</p>
                <h2 class="mt-1 font-display text-3xl font-semibold text-navy">{{ instructor.name }}</h2>
            </div>
        </template>

        <div class="px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid gap-4 md:grid-cols-3">
                <article class="border border-navy/10 bg-white p-5">
                    <p class="text-xs uppercase tracking-[0.16em] text-navy-muted">Courses</p>
                    <p class="mt-3 font-display text-4xl text-navy">{{ stats.courses }}</p>
                </article>
                <article class="border border-navy/10 bg-white p-5">
                    <p class="text-xs uppercase tracking-[0.16em] text-navy-muted">Published</p>
                    <p class="mt-3 font-display text-4xl text-navy">{{ stats.published }}</p>
                </article>
                <article class="border border-navy/10 bg-white p-5">
                    <p class="text-xs uppercase tracking-[0.16em] text-navy-muted">Students</p>
                    <p class="mt-3 font-display text-4xl text-navy">{{ stats.students }}</p>
                </article>
            </div>

            <section class="mt-8 border border-navy/10 bg-white p-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-display text-2xl font-semibold text-navy">Your courses</h3>
                    <Link :href="route('instructor.courses.create')" class="text-xs font-semibold uppercase tracking-[0.12em] text-teal">
                        Add course
                    </Link>
                </div>
                <div v-if="courses.length" class="mt-4 space-y-3">
                    <div v-for="course in courses" :key="course.id" class="flex items-center justify-between border-t border-navy/10 pt-3">
                        <div>
                            <p class="font-medium text-navy">{{ course.title }}</p>
                            <p class="text-xs text-navy-muted">{{ course.type_label }} · {{ course.status_label }}</p>
                        </div>
                        <Link :href="route('instructor.courses.edit', course.id)" class="text-xs font-semibold uppercase tracking-[0.12em] text-teal">
                            Edit
                        </Link>
                    </div>
                </div>
                <p v-else class="mt-3 text-sm text-navy-muted">No courses yet. Create your first free, short, or paid course.</p>
            </section>
        </div>
    </PortalLayout>
</template>
