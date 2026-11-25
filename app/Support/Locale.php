<?php

namespace App\Support;

class Locale
{
    public const ENGLISH = 'en';

    public const ARABIC = 'ar';

    /**
     * @return list<string>
     */
    public static function supported(): array
    {
        return [self::ENGLISH, self::ARABIC];
    }

    public static function isSupported(string $locale): bool
    {
        return in_array($locale, self::supported(), true);
    }

    public static function direction(?string $locale = null): string
    {
        $locale ??= app()->getLocale();

        return $locale === self::ARABIC ? 'rtl' : 'ltr';
    }

    /**
     * @return array<string, string>
     */
    public static function translations(?string $locale = null): array
    {
        $locale ??= app()->getLocale();
        $path = lang_path("{$locale}.json");

        if (! is_file($path)) {
            return [];
        }

        /** @var array<string, string>|null $decoded */
        $decoded = json_decode((string) file_get_contents($path), true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * @return list<array{code: string, label: string, native_label: string}>
     */
    public static function options(): array
    {
        return [
            [
                'code' => self::ENGLISH,
                'label' => 'English',
                'native_label' => 'English',
            ],
            [
                'code' => self::ARABIC,
                'label' => 'Arabic',
                'native_label' => 'العربية',
            ],
        ];
    }
}
