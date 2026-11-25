<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useLang } from '@/Composables/useLang';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, watch } from 'vue';

const props = defineProps({
    countries: {
        type: Array,
        default: () => [],
    },
});

const { t } = useLang();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    id_passport: '',
    phone: '+20',
    affiliation: '',
    country: 'Egypt',
    certificates_note: '',
});

const selectedCountry = computed(() =>
    props.countries.find((country) => country.name === form.country),
);

const dialCode = computed(() => selectedCountry.value?.dial_code || '');

watch(
    () => form.country,
    () => {
        if (!dialCode.value) {
            return;
        }

        const localNumber = form.phone.replace(/^\+\d+\s*/, '').trim();
        form.phone = localNumber ? `${dialCode.value}${localNumber}` : dialCode.value;
    },
);

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head :title="t('auth.register.title')" />

        <div class="mb-6">
            <p class="text-[0.68rem] font-semibold uppercase tracking-[0.2em] text-teal">
                {{ t('auth.register.eyebrow') }}
            </p>
            <h1 class="mt-2 font-display text-2xl font-semibold text-navy">
                {{ t('auth.register.heading') }}
            </h1>
            <p class="mt-2 text-sm text-navy-muted">
                {{ t('auth.register.lead') }}
            </p>
        </div>

        <form class="space-y-4" @submit.prevent="submit">
            <div>
                <InputLabel for="name" :value="t('auth.register.name')" />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" :value="t('auth.register.email')" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="id_passport" :value="t('auth.register.id_passport')" />
                <TextInput
                    id="id_passport"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.id_passport"
                    required
                />
                <InputError class="mt-2" :message="form.errors.id_passport" />
            </div>

            <div>
                <InputLabel for="affiliation" :value="t('auth.register.affiliation')" />
                <TextInput
                    id="affiliation"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.affiliation"
                    required
                    :placeholder="t('auth.register.affiliation_ph')"
                />
                <InputError class="mt-2" :message="form.errors.affiliation" />
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <InputLabel for="country" :value="t('auth.register.country')" />
                    <select
                        id="country"
                        v-model="form.country"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-navy focus:ring-navy"
                    >
                        <option disabled value="">{{ t('auth.register.country_ph') }}</option>
                        <option
                            v-for="country in countries"
                            :key="country.code"
                            :value="country.name"
                        >
                            {{ country.label }} ({{ country.dial_code }})
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.country" />
                </div>
                <div>
                    <InputLabel for="phone" :value="t('auth.register.phone')" />
                    <TextInput
                        id="phone"
                        type="tel"
                        class="mt-1 block w-full"
                        v-model="form.phone"
                        required
                        autocomplete="tel"
                        :placeholder="dialCode ? `${dialCode}1XXXXXXXXX` : t('auth.register.phone')"
                    />
                    <p v-if="dialCode" class="mt-1 text-xs text-navy-muted">
                        {{ t('auth.register.phone_hint', { code: dialCode }) }}
                    </p>
                    <InputError class="mt-2" :message="form.errors.phone" />
                </div>
            </div>

            <div>
                <InputLabel for="certificates_note" :value="t('auth.register.certificates')" />
                <textarea
                    id="certificates_note"
                    v-model="form.certificates_note"
                    rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-navy focus:ring-navy"
                    :placeholder="t('auth.register.certificates_ph')"
                />
                <InputError class="mt-2" :message="form.errors.certificates_note" />
            </div>

            <div>
                <InputLabel for="password" :value="t('auth.register.password')" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div>
                <InputLabel for="password_confirmation" :value="t('auth.register.password_confirm')" />
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-between gap-3 pt-2">
                <Link
                    :href="route('login')"
                    class="text-sm text-navy-muted underline hover:text-navy"
                >
                    {{ t('auth.register.already') }}
                </Link>

                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    {{ t('auth.register.submit') }}
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
