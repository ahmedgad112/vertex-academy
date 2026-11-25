<script setup>
import PortalLayout from '@/Layouts/PortalLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, watch } from 'vue';

const props = defineProps({
    course: Object,
    types: Array,
    statuses: Array,
});

const isEditing = computed(() => !!props.course);

const form = useForm({
    title: props.course?.title || '',
    summary: props.course?.summary || '',
    description: props.course?.description || '',
    type: props.course?.type || 'paid',
    status: props.course?.status || 'draft',
    price: props.course?.price ?? 0,
    currency: props.course?.currency || 'USD',
    duration_hours: props.course?.duration_hours || '',
    level: props.course?.level || 'Beginner',
});

watch(
    () => form.type,
    (type) => {
        if (type === 'free') form.price = 0;
    },
);

const links = computed(() => [
    { label: 'Instructor Desk', href: route('instructor.dashboard'), match: 'instructor.dashboard' },
    { label: 'My Courses', href: route('instructor.courses.index'), match: 'instructor.courses.*' },
    { label: 'Profile', href: route('profile.edit'), match: 'profile.*' },
]);

const submit = () => {
    if (isEditing.value) {
        form.put(route('instructor.courses.update', props.course.id));
        return;
    }
    form.post(route('instructor.courses.store'));
};
</script>

<template>
    <Head :title="isEditing ? 'Edit Course' : 'Create Course'" />

    <PortalLayout portal="instructor" title="Instructor Portal" :links="links">
        <template #header>
            <h2 class="font-display text-3xl font-semibold text-navy">
                {{ isEditing ? 'Edit course' : 'Create course' }}
            </h2>
        </template>

        <div class="px-4 py-8 sm:px-6 lg:px-8">
            <form class="max-w-3xl space-y-4 border border-navy/10 bg-white p-6" @submit.prevent="submit">
                <div>
                    <InputLabel for="title" value="Title" />
                    <TextInput id="title" v-model="form.title" class="mt-1 block w-full" required />
                    <InputError class="mt-2" :message="form.errors.title" />
                </div>
                <div>
                    <InputLabel for="summary" value="Summary" />
                    <TextInput id="summary" v-model="form.summary" class="mt-1 block w-full" />
                </div>
                <div>
                    <InputLabel for="description" value="Description" />
                    <textarea id="description" v-model="form.description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-navy focus:ring-navy" />
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <InputLabel for="type" value="Type" />
                        <select id="type" v-model="form.type" class="mt-1 block w-full rounded-md border-gray-300">
                            <option v-for="type in types" :key="type.value" :value="type.value">{{ type.label }}</option>
                        </select>
                    </div>
                    <div>
                        <InputLabel for="status" value="Status" />
                        <select id="status" v-model="form.status" class="mt-1 block w-full rounded-md border-gray-300">
                            <option v-for="status in statuses" :key="status.value" :value="status.value">{{ status.label }}</option>
                        </select>
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <InputLabel for="price" value="Price" />
                        <TextInput id="price" type="number" step="0.01" v-model="form.price" class="mt-1 block w-full" :disabled="form.type === 'free'" />
                    </div>
                    <div>
                        <InputLabel for="currency" value="Currency" />
                        <TextInput id="currency" v-model="form.currency" class="mt-1 block w-full" />
                    </div>
                    <div>
                        <InputLabel for="duration_hours" value="Hours" />
                        <TextInput id="duration_hours" type="number" v-model="form.duration_hours" class="mt-1 block w-full" />
                    </div>
                </div>
                <div class="flex items-center justify-between pt-2">
                    <Link :href="route('instructor.courses.index')" class="text-sm underline">Cancel</Link>
                    <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                </div>
            </form>
        </div>
    </PortalLayout>
</template>
