<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleSwitchTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_shares_locale_and_translations(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('Home')
                ->where('locale', 'en')
                ->where('direction', 'ltr')
                ->has('translations')
                ->has('locales', 2));
    }

    public function test_user_can_switch_to_arabic(): void
    {
        $this->from('/')
            ->post(route('locale.update', 'ar'))
            ->assertRedirect('/');

        $this->get('/')
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->where('locale', 'ar')
                ->where('direction', 'rtl')
                ->where('translations', function ($translations) {
                    $items = $translations instanceof \Illuminate\Support\Collection
                        ? $translations->all()
                        : (array) $translations;

                    return ($items['nav.about'] ?? null) === 'من نحن';
                }));
    }

    public function test_unsupported_locale_is_rejected(): void
    {
        $this->post(route('locale.update', 'fr'))
            ->assertNotFound();
    }
}
