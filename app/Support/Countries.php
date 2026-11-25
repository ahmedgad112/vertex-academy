<?php

namespace App\Support;

class Countries
{
    /**
     * @return list<array{code: string, name: string, name_ar: string, dial_code: string}>
     */
    public static function all(): array
    {
        return [
            ['code' => 'EG', 'name' => 'Egypt', 'name_ar' => 'مصر', 'dial_code' => '+20'],
            ['code' => 'SA', 'name' => 'Saudi Arabia', 'name_ar' => 'السعودية', 'dial_code' => '+966'],
            ['code' => 'AE', 'name' => 'United Arab Emirates', 'name_ar' => 'الإمارات', 'dial_code' => '+971'],
            ['code' => 'KW', 'name' => 'Kuwait', 'name_ar' => 'الكويت', 'dial_code' => '+965'],
            ['code' => 'QA', 'name' => 'Qatar', 'name_ar' => 'قطر', 'dial_code' => '+974'],
            ['code' => 'BH', 'name' => 'Bahrain', 'name_ar' => 'البحرين', 'dial_code' => '+973'],
            ['code' => 'OM', 'name' => 'Oman', 'name_ar' => 'عُمان', 'dial_code' => '+968'],
            ['code' => 'JO', 'name' => 'Jordan', 'name_ar' => 'الأردن', 'dial_code' => '+962'],
            ['code' => 'LB', 'name' => 'Lebanon', 'name_ar' => 'لبنان', 'dial_code' => '+961'],
            ['code' => 'IQ', 'name' => 'Iraq', 'name_ar' => 'العراق', 'dial_code' => '+964'],
            ['code' => 'SY', 'name' => 'Syria', 'name_ar' => 'سوريا', 'dial_code' => '+963'],
            ['code' => 'PS', 'name' => 'Palestine', 'name_ar' => 'فلسطين', 'dial_code' => '+970'],
            ['code' => 'SD', 'name' => 'Sudan', 'name_ar' => 'السودان', 'dial_code' => '+249'],
            ['code' => 'LY', 'name' => 'Libya', 'name_ar' => 'ليبيا', 'dial_code' => '+218'],
            ['code' => 'TN', 'name' => 'Tunisia', 'name_ar' => 'تونس', 'dial_code' => '+216'],
            ['code' => 'DZ', 'name' => 'Algeria', 'name_ar' => 'الجزائر', 'dial_code' => '+213'],
            ['code' => 'MA', 'name' => 'Morocco', 'name_ar' => 'المغرب', 'dial_code' => '+212'],
            ['code' => 'TR', 'name' => 'Turkey', 'name_ar' => 'تركيا', 'dial_code' => '+90'],
            ['code' => 'GB', 'name' => 'United Kingdom', 'name_ar' => 'المملكة المتحدة', 'dial_code' => '+44'],
            ['code' => 'US', 'name' => 'United States', 'name_ar' => 'الولايات المتحدة', 'dial_code' => '+1'],
            ['code' => 'CA', 'name' => 'Canada', 'name_ar' => 'كندا', 'dial_code' => '+1'],
            ['code' => 'DE', 'name' => 'Germany', 'name_ar' => 'ألمانيا', 'dial_code' => '+49'],
            ['code' => 'FR', 'name' => 'France', 'name_ar' => 'فرنسا', 'dial_code' => '+33'],
            ['code' => 'IN', 'name' => 'India', 'name_ar' => 'الهند', 'dial_code' => '+91'],
            ['code' => 'PK', 'name' => 'Pakistan', 'name_ar' => 'باكستان', 'dial_code' => '+92'],
            ['code' => 'NG', 'name' => 'Nigeria', 'name_ar' => 'نيجيريا', 'dial_code' => '+234'],
            ['code' => 'KE', 'name' => 'Kenya', 'name_ar' => 'كينيا', 'dial_code' => '+254'],
            ['code' => 'ZA', 'name' => 'South Africa', 'name_ar' => 'جنوب أفريقيا', 'dial_code' => '+27'],
            ['code' => 'AU', 'name' => 'Australia', 'name_ar' => 'أستراليا', 'dial_code' => '+61'],
            ['code' => 'OTHER', 'name' => 'Other', 'name_ar' => 'أخرى', 'dial_code' => '+'],
        ];
    }

    /**
     * @return list<string>
     */
    public static function names(): array
    {
        return array_column(self::all(), 'name');
    }

    /**
     * @return list<array{code: string, name: string, label: string, dial_code: string}>
     */
    public static function options(?string $locale = null): array
    {
        $locale ??= app()->getLocale();

        return array_map(
            fn (array $country): array => [
                'code' => $country['code'],
                'name' => $country['name'],
                'label' => $locale === Locale::ARABIC ? $country['name_ar'] : $country['name'],
                'dial_code' => $country['dial_code'],
            ],
            self::all(),
        );
    }
}
