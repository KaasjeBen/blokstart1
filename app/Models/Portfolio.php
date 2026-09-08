<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    public const AVAILABLE_TAGS = [
        'web-design' => 'Web Design',
        'development' => 'Development',
        'branding' => 'Branding',
        'photography' => 'Photography',
        'illustration' => 'Illustration',
        'ui-ux' => 'UI/UX',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'email',
        'phone',
        'tags',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
        ];
    }

    public static function availableTags(): array
    {
        return self::AVAILABLE_TAGS;
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return str_starts_with($this->image, 'images/')
            ? asset('storage/'.$this->image)
            : asset($this->image);
    }
}
