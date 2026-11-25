<script setup>
import PortalLayout from '@/Layouts/PortalLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    courses: Object,
    filters: Object,
    types: Array,
});

const page = usePage();

const links = computed(() => [
    { label: 'Overview', href: route('admin.dashboard'), match: 'admin.dashboard' },
    { label: 'Courses', href: route('admin.courses.index'), match: 'admin.courses.*' },
    { label: 'Users & Roles', href: route('admin.users.index'), match: 'admin.users.*' },
    { label: 'Profile', href: route('profile.edit'), match: 'profile.*' },
]);

const filterType = (type) => {
    router.get(route('admin.courses.index'), { type: type || undefined }, { preserveState: true, replace: true });
};

const destroyCourse = (course) => {
    if (! confirm(`Delete "${course.title}"?`)) return;
    router.delete(route('admin.courses.destroy', course.id));
};
</script>

<template>
    <Head title="Courses · Admin" />

    <PortalLayout portal="admin" title="Admin Portal" :links="links">
        <template #header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-muted">Catalog</p>
                    <h2 class="mt-1 font-display text-3xl font-semibold text-navy">Courses</h2>
                </div>
                <Link
                    :href="route('admin.courses.create')"
                    class="inline-flex rounded-sm bg-navy px-4 py-2 text-xs font-semibold uppercase tracking-[0.16em] text-ivory"
                >
                    Add course
                </Link>
            </div>
        </template>

        <div class="px-4 py-8 sm:px-6 lg:px-8">
            <div v-if="page.props.flash?.success" class="mb-5 border border-teal/30 bg-teal-mist px-4 py-3 text-sm text-teal-dark">
                {{ page.props.flash.success }}
            </div>

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
                <article
                    v-for="course in courses.data"
                    :key="course.id"
                    class="border border-navy/10 bg-white p-5"
                >
                    <div class="flex items-start justify-between gap-3">
                        <span class="rounded-sm bg-teal-mist px-2 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.12em] text-teal-dark">
                            {{ course.type_label }}
                        </span>
                        <span class="text-xs text-navy-muted">{{ course.status_label }}</span>
                    </div>
                    <h3 class="mt-3 font-display text-2xl font-semibold text-navy">{{ course.title }}</h3>
                    <p class="mt-2 text-sm text-navy-muted">{{ course.summary }}</p>
                    <div class="mt-4 flex items-center justify-between text-sm">
                        <span class="font-semibold text-navy">{{ course.price_label }}</span>
                        <span class="text-navy-muted">{{ course.students_count || 0 }} students</span>
                    </div>
                    <div class="mt-4 flex gap-3">
                        <Link :href="route('admin.courses.edit', course.id)" class="text-xs font-semibold uppercase tracking-[0.12em] text-teal">
                            Edit
                        </Link>
                        <button type="button" class="text-xs font-semibold uppercase tracking-[0.12em] text-red-700" @click="destroyCourse(course)">
                            Delete
                        </button>
                    </div>
                </article>
            </div>
        </div>
    </PortalLayout>
</template>
