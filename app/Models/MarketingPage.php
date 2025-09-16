<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

/**
 * Class MarketingPage
 *
 * @property int $id
 * @property string $url
 * @property bool $marked_helpful
 * @property bool $marked_not_helpful
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
final class MarketingPage extends Model
{
    /** @use HasFactory<\Database\Factories\MarketingPageFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'marketing_pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'url',
        'marked_helpful',
        'marked_not_helpful',
    ];

    /**
     * Get the users associated with the marketing page.
     *
     * @return BelongsToMany<User, $this, MarketingPageUser>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            related: User::class,
            table: 'marketing_page_user',
            foreignPivotKey: 'marketing_page_id',
            relatedPivotKey: 'user_id',
        )
            ->using(MarketingPageUser::class)
            ->withPivot('helpful', 'comment')
            ->withTimestamps();
    }
}
