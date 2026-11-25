<?php

namespace App\Models;

use App\Enums\CourseStatus;
use App\Enums\CourseType;
use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable([
    'instructor_id',
    'title',
    'slug',
    'summary',
    'description',
    'type',
    'status',
    'price_cents',
    'currency',
    'duration_hours',
    'level',
    'thumbnail_path',
    'published_at',
])]
class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => CourseType::class,
            'status' => CourseStatus::class,
            'price_cents' => 'integer',
            'duration_hours' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Course $course): void {
            if (blank($course->slug)) {
                $course->slug = static::uniqueSlugFor($course->title);
            }
        });
    }

    public static function uniqueSlugFor(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 1;

        while (static::query()->where('slug', $slug)->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * @return HasMany<Enrollment, $this>
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * @param  Builder<Course>  $query
     * @return Builder<Course>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', CourseStatus::Published);
    }

    public function isFree(): bool
    {
        return $this->type === CourseType::Free;
    }

    public function requiresPayment(): bool
    {
        return $this->type->requiresPayment();
    }

    public function priceLabel(): string
    {
        if ($this->isFree() || $this->price_cents <= 0) {
            return __('course.price.free');
        }

        return strtoupper($this->currency).' '.number_format($this->price_cents / 100, 2);
    }
}
