<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;

class Image extends Model
{
    use HasFactory;
    use Attachable;

    protected $fillable = [
        'name',
        'gallery_id',
        'attachment_id'
    ];

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }

    public function attachment(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }

}
