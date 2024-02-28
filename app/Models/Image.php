<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property int id
 * @property string name
 * @property int gallery_id
 * @property int attachment_id
 *
 * @method static Builder|Image query()
 * @method static Image create(array $fields)
 */
class Image extends Model
{
    use HasFactory;
    use Attachable;
    use AsSource;
    use Filterable;

    protected $fillable = [
        'name',
        'gallery_id',
        'attachment_id'
    ];

    //Relations
    /**
     * @return BelongsTo
     */
    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }

    /**
     * @return HasOne
     */
    public function attachment(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }

}
