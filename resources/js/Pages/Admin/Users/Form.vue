<script setup>
import PortalLayout from '@/Layouts/PortalLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    user: Object,
    roles: Array,
    permissionMatrix: Object,
});

const isEditing = computed(() => !!props.user);

const form = useForm({
    name: props.user?.name || '',
    email: props.user?.email || '',
    password: '',
    password_confirmation: '',
    role: props.user?.role || 'student',
    is_active: props.user?.is_active ?? true,
    id_passport: props.user?.id_passport || '',
    phone: props.user?.phone || '',
    affiliation: props.user?.affiliation || '',
    country: props.user?.country || '',
    certificates_note: props.user?.certificates_note || '',
});

const links = computed(() => [
    { label: 'Overview', href: route('admin.dashboard'), match: 'admin.dashboard' },
    { label: 'Users & Roles', href: route('admin.users.index'), match: 'admin.users.*' },
    { label: 'Profile', href: route('profile.edit'), match: 'profile.*' },
]);

const selectedPermissions = computed(
    () => props.permissionMatrix[form.role] || [],
);

const submit = () => {
    if (isEditing.value) {
        form.put(route('admin.users.update', props.user.id));
        return;
    }

    form.post(route('admin.users.store'));
};
</script>

<template>
    <Head :title="isEditing ? 'Edit User' : 'Create User'" />

    <PortalLayout portal="admin" title="Admin Portal" :links="links">
        <template #header>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-muted">
                    Access control
                </p>
                <h2 class="mt-1 font-display text-3xl font-semibold text-navy">
                    {{ isEditing ? 'Edit user' : 'Create user' }}
                </h2>
            </div>
        </template>

        <div class="px-4 py-8 sm:px-6 lg:px-8">
            <form class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]" @submit.prevent="submit">
                <div class="space-y-4 border border-navy/10 bg-white p-6">
                    <div>
                        <InputLabel for="name" value="Full name" />
                        <TextInput id="name" v-model="form.name" class="mt-1 block w-full" required />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput id="email" type="email" v-model="form.email" class="mt-1 block w-full" required />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <InputLabel for="role" value="Role" />
                            <select
                                id="role"
                                v-model="form.role"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-navy focus:ring-navy"
                            >
                                <option v-for="role in roles" :key="role.value" :value="role.value">
                                    {{ role.label }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.role" />
                        </div>

                        <div>
                            <InputLabel for="is_active" value="Status" />
                            <select
                                id="is_active"
                                v-model="form.is_active"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-navy focus:ring-navy"
                            >
                                <option :value="true">Active</option>
                                <option :value="false">Inactive</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.is_active" />
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <InputLabel for="password" :value="isEditing ? 'New password (optional)' : 'Password'" />
                            <TextInput
                                id="password"
                                type="password"
                                v-model="form.password"
                                class="mt-1 block w-full"
                                :required="!isEditing"
                                autocomplete="new-password"
                            />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>
                        <div>
                            <InputLabel for="password_confirmation" value="Confirm password" />
                            <TextInput
                                id="password_confirmation"
                                type="password"
                                v-model="form.password_confirmation"
                                class="mt-1 block w-full"
                                :required="!isEditing"
                                autocomplete="new-password"
                            />
                        </div>
                    </div>

                    <div v-if="form.role === 'student'" class="space-y-4 border-t border-navy/10 pt-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-teal">
                            Student profile
                        </p>
                        <div>
                            <InputLabel for="id_passport" value="ID / Passport" />
                            <TextInput id="id_passport" v-model="form.id_passport" class="mt-1 block w-full" />
                            <InputError class="mt-2" :message="form.errors.id_passport" />
                        </div>
                        <div>
                            <InputLabel for="affiliation" value="Affiliation" />
                            <TextInput id="affiliation" v-model="form.affiliation" class="mt-1 block w-full" />
                            <InputError class="mt-2" :message="form.errors.affiliation" />
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <InputLabel for="phone" value="Phone" />
                                <TextInput id="phone" v-model="form.phone" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <InputLabel for="country" value="Country" />
                                <TextInput id="country" v-model="form.country" class="mt-1 block w-full" />
                            </div>
                        </div>
                        <div>
                            <InputLabel for="certificates_note" value="Certificates note" />
                            <textarea
                                id="certificates_note"
                                v-model="form.certificates_note"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-navy focus:ring-navy"
                            />
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-3 pt-2">
                        <Link :href="route('admin.users.index')" class="text-sm text-navy-muted underline">
                            Cancel
                        </Link>
                        <PrimaryButton :disabled="form.processing">
                            {{ isEditing ? 'Save changes' : 'Create user' }}
                        </PrimaryButton>
                    </div>
                </div>

                <aside class="border border-navy/10 bg-navy p-6 text-ivory">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gold-soft">
                        Permissions for {{ form.role }}
                    </p>
                    <ul class="mt-4 space-y-2 text-sm text-ivory/80">
                        <li v-for="permission in selectedPermissions" :key="permission.value">
                            • {{ permission.label }}
                        </li>
                    </ul>
                </aside>
            </form>
        </div>
    </PortalLayout>
</template>
