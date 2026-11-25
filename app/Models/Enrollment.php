<?php

namespace App\Models;

use App\Enums\EnrollmentStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'course_id',
    'status',
    'amount_paid_cents',
    'currency',
    'payment_reference',
    'paid_at',
    'unlocked_at',
    'progress_percent',
])]
class Enrollment extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => EnrollmentStatus::class,
            'amount_paid_cents' => 'integer',
            'progress_percent' => 'integer',
            'paid_at' => 'datetime',
            'unlocked_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Course, $this>
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * @param  Builder<Enrollment>  $query
     * @return Builder<Enrollment>
     */
    public function scopeUnlocked(Builder $query): Builder
    {
        return $query->whereIn('status', [
            EnrollmentStatus::Active,
            EnrollmentStatus::Completed,
        ]);
    }

    public function isUnlocked(): bool
    {
        return $this->status->unlocksAccess();
    }
}
