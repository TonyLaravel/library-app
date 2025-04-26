<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'author', 'description', 'cover_image',
        'publisher', 'publication_date', 'category', 'isbn',
        'page_count', 'available', 'featured', 'slug',
    ];

    protected $casts = [
        'publication_date' => 'date',
        'available'        => 'boolean',
        'featured'         => 'boolean',
    ];

    /** Virtual columns automatically added to JSON */
    protected $appends = [
        'is_available',
        'average_rating',
        'rating_count',
    ];

    /** Keep slug in sync with the title */
    public function setTitleAttribute(string $value): void
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug']  = Str::slug($value);
    }

    /** Round to one decimal place */
    public function getAverageRatingAttribute(): float
    {
        return round($this->ratings_avg_value ?? 0, 1);
    }

    public function getRatingCountAttribute(): int
    {
        return $this->ratings_count ?? 0;
    }

    /**
     * `is_available` virtual attribute.
     */
    public function getIsAvailableAttribute(): bool
    {
        if ($this->relationLoaded('activeLoan')) {
            return is_null($this->activeLoan);
        }

        return ! $this->activeLoan()->exists();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function activeLoan()
    {
        return $this->hasOne(Loan::class)->whereNull('returned_at');
    }

    /** `?search=foo` => WHERE title LIKE %foo%  */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $term
            ? $query->where('title', 'like', "%{$term}%")
            : $query;
    }

    /** Adds ratings_avg_value & ratings_count columns */
    public function scopeWithRatingStats(Builder $query): Builder
    {
        return $query
            ->withAvg('ratings', 'value')
            ->withCount('ratings');
    }

    /** Always eager-load activeLoan for fast availability checks */
    public function scopeWithActiveLoan(Builder $query): Builder
    {
        return $query->with('activeLoan');
    }
}
