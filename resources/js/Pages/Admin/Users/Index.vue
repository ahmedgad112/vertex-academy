<script setup>
import PortalLayout from '@/Layouts/PortalLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

const props = defineProps({
    users: Object,
    filters: Object,
    roles: Array,
    permissionMatrix: Object,
    can: Object,
});

const page = usePage();
const search = ref(props.filters.search || '');

const links = computed(() => [
    { label: 'Overview', href: route('admin.dashboard'), match: 'admin.dashboard' },
    { label: 'Users & Roles', href: route('admin.users.index'), match: 'admin.users.*' },
    { label: 'Profile', href: route('profile.edit'), match: 'profile.*' },
]);

const applyFilters = (extra = {}) => {
    router.get(
        route('admin.users.index'),
        {
            role: props.filters.role || undefined,
            search: search.value || undefined,
            ...extra,
        },
        { preserveState: true, replace: true },
    );
};

watch(search, (value, oldValue) => {
    if (value === oldValue) {
        return;
    }

    clearTimeout(window.__userSearchTimer);
    window.__userSearchTimer = setTimeout(() => applyFilters(), 350);
});

const destroyUser = (user) => {
    if (! confirm(`Delete ${user.name}? This cannot be undone.`)) {
        return;
    }

    router.delete(route('admin.users.destroy', user.id));
};
</script>

<template>
    <Head title="Users & Permissions · Admin" />

    <PortalLayout portal="admin" title="Admin Portal" :links="links">
        <template #header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-muted">
                        Access control
                    </p>
                    <h2 class="mt-1 font-display text-3xl font-semibold text-navy">
                        Users & permissions
                    </h2>
                </div>
                <Link
                    v-if="can.create"
                    :href="route('admin.users.create')"
                    class="inline-flex rounded-sm bg-navy px-4 py-2 text-xs font-semibold uppercase tracking-[0.16em] text-ivory"
                >
                    Add user
                </Link>
            </div>
        </template>

        <div class="px-4 py-8 sm:px-6 lg:px-8">
            <div
                v-if="page.props.flash?.success"
                class="mb-5 border border-teal/30 bg-teal-mist px-4 py-3 text-sm text-teal-dark"
            >
                {{ page.props.flash.success }}
            </div>

            <div class="mb-5 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-wrap gap-2">
                    <button
                        type="button"
                        class="rounded-sm px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.14em]"
                        :class="!filters.role ? 'bg-navy text-ivory' : 'border border-navy/15 text-navy'"
                        @click="applyFilters({ role: undefined })"
                    >
                        All
                    </button>
                    <button
                        v-for="role in roles"
                        :key="role.value"
                        type="button"
                        class="rounded-sm px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.14em]"
                        :class="
                            filters.role === role.value
                                ? 'bg-navy text-ivory'
                                : 'border border-navy/15 text-navy'
                        "
                        @click="applyFilters({ role: role.value })"
                    >
                        {{ role.label }}
                    </button>
                </div>

                <input
                    v-model="search"
                    type="search"
                    placeholder="Search name or email"
                    class="w-full rounded-sm border-navy/15 text-sm lg:max-w-xs"
                />
            </div>

            <div class="overflow-x-auto border border-navy/10 bg-white">
                <table class="min-w-full divide-y divide-navy/10 text-start text-sm">
                    <thead class="bg-ivory">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-navy">Name</th>
                            <th class="px-4 py-3 font-semibold text-navy">Role</th>
                            <th class="px-4 py-3 font-semibold text-navy">Status</th>
                            <th class="px-4 py-3 font-semibold text-navy">Permissions</th>
                            <th class="px-4 py-3 font-semibold text-navy">Joined</th>
                            <th class="px-4 py-3 font-semibold text-navy">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy/10">
                        <tr v-for="user in users.data" :key="user.id">
                            <td class="px-4 py-3">
                                <p class="font-medium text-navy">{{ user.name }}</p>
                                <p class="text-xs text-navy-muted">{{ user.email }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <span class="rounded-sm bg-teal-mist px-2 py-1 text-xs font-semibold text-teal-dark">
                                    {{ user.role_label }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="rounded-sm px-2 py-1 text-xs font-semibold"
                                    :class="
                                        user.is_active
                                            ? 'bg-teal-mist text-teal-dark'
                                            : 'bg-red-50 text-red-700'
                                    "
                                >
                                    {{ user.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-navy-muted">
                                {{ user.permissions?.length || 0 }} grants
                            </td>
                            <td class="px-4 py-3 text-navy-muted">{{ user.created_at }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-2">
                                    <Link
                                        :href="route('admin.users.edit', user.id)"
                                        class="text-xs font-semibold uppercase tracking-[0.12em] text-teal hover:text-navy"
                                    >
                                        Edit
                                    </Link>
                                    <button
                                        v-if="page.props.auth.user.id !== user.id"
                                        type="button"
                                        class="text-xs font-semibold uppercase tracking-[0.12em] text-red-700 hover:text-red-900"
                                        @click="destroyUser(user)"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <section class="mt-8 border border-navy/10 bg-white p-6">
                <h3 class="font-display text-2xl font-semibold text-navy">Role permission matrix</h3>
                <p class="mt-2 text-sm text-navy-muted">
                    Each role unlocks a fixed set of portal abilities. Admins manage the directory;
                    instructors teach; students learn and enroll.
                </p>

                <div class="mt-6 grid gap-4 lg:grid-cols-3">
                    <div
                        v-for="role in roles"
                        :key="role.value"
                        class="border border-navy/10 p-4"
                    >
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-teal">
                            {{ role.label }}
                        </p>
                        <ul class="mt-3 space-y-2 text-sm text-navy-muted">
                            <li
                                v-for="permission in permissionMatrix[role.value]"
                                :key="permission.value"
                            >
                                {{ permission.label }}
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </PortalLayout>
</template>
