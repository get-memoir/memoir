<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MastodonEntry
 *
 * @property int $id
 * @property string $mastodon_username
 * @property string $content
 * @property string $url
 * @property Carbon $published_at
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
final class MastodonEntry extends Model
{
    /** @use HasFactory<\Database\Factories\MastodonEntryFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mastodon_entries';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'mastodon_username',
        'content',
        'url',
        'published_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }
}
