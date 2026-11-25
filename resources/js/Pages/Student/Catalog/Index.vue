<script setup>
import PortalLayout from '@/Layouts/PortalLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    courses: Object,
    filters: Object,
    types: Array,
});

const links = computed(() => [
    { label: 'My Desk', href: route('student.dashboard'), match: 'student.dashboard' },
    { label: 'Browse Courses', href: route('student.courses.index'), match: 'student.courses.*' },
    { label: 'My Library', href: route('student.library'), match: 'student.library' },
    { label: 'Profile', href: route('profile.edit'), match: 'profile.*' },
]);

const filterType = (type) => {
    router.get(route('student.courses.index'), { type: type || undefined }, { preserveState: true, replace: true });
};
</script>

<template>
    <Head title="Browse Courses" />

    <PortalLayout portal="student" title="Student Portal" :links="links">
        <template #header>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-teal">Catalog</p>
                <h2 class="mt-1 font-display text-3xl font-semibold text-navy">Browse courses</h2>
            </div>
        </template>

        <div class="px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-5 flex flex-wrap gap-2">
                <button
                    type="button"
                    class="rounded-sm px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.14em]"
                    :class="!filters.type ? 'bg-navy text-ivory' : 'border border-navy/15 text-navy'"
                    @click="filterType(null)"
                >
                    All
                </button>
                <button
                    v-for="type in types"
                    :key="type.value"
                    type="button"
                    class="rounded-sm px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.14em]"
                    :class="filters.type === type.value ? 'bg-navy text-ivory' : 'border border-navy/15 text-navy'"
                    @click="filterType(type.value)"
                >
                    {{ type.label }}
                </button>
            </div>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                <article v-for="course in courses.data" :key="course.id" class="flex flex-col border border-navy/10 bg-white p-5">
                    <div class="flex items-center justify-between gap-2">
                        <span class="rounded-sm bg-teal-mist px-2 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.12em] text-teal-dark">
                            {{ course.type_label }}
                        </span>
                        <span class="text-sm font-semibold text-navy">{{ course.price_label }}</span>
                    </div>
                    <h3 class="mt-3 font-display text-2xl font-semibold text-navy">{{ course.title }}</h3>
                    <p class="mt-2 flex-1 text-sm text-navy-muted">{{ course.summary }}</p>
                    <p class="mt-3 text-xs text-navy-muted">By {{ course.instructor?.name || 'Vertex Faculty' }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <Link :href="route('student.courses.show', course.slug)" class="text-xs font-semibold uppercase tracking-[0.12em] text-teal">
                            View details
                        </Link>
                        <span v-if="course.enrollment?.unlocked" class="text-xs font-semibold text-teal-dark">In library</span>
                        <span v-else-if="course.enrollment?.status === 'pending_payment'" class="text-xs font-semibold text-gold-muted">Payment pending</span>
                    </div>
                </article>
            </div>
        </div>
    </PortalLayout>
</template>
