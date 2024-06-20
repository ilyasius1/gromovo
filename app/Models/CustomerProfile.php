<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Screen\AsSource;

/**
 * @property int id
 * @property string full_name
 * @property string phone
 * @property string email
 * @property string document_number
 * @property string document_issued_by
 * @property string document_issued_at
 * @property string address
 * @property string birthdate
 * @property bool news_subscription
 * @property string created_at
 * @property string updated_at
 *
 * @method static Builder|CustomerProfile query()
 * @method static CustomerProfile create(array $fields)
 * @method Builder|CustomerProfile active()
 * @method static Builder|CustomerProfile where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder|CustomerProfile filters()
 * @method static Builder|CustomerProfile defaultSort(string $column, string $direction = 'asc')
 */
class CustomerProfile extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'document_number',
        'document_issued_by',
        'document_issued_at',
        'address',
        'birthdate',
        'news_subscription'
    ];

    //Orchid filters and sorts
    protected array $allowedFilters = [
        'id' => Where::class,
        'full_name' => Where::class,
        'phone' => Where::class,
        'email' => Where::class,
        'document_number' => Where::class,
        'birthdate' => WhereDateStartEnd::class,
        'news_subscription' => Where::class,
        'created_at' => WhereDateStartEnd::class,
        'updated_at' => WhereDateStartEnd::class
    ];

    protected array $allowedSorts = [
        'id',
        'full_name',
        'phone',
        'email',
        'document_number',
        'created_at',
        'updated_at'
    ];

    //Relations
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'customer_profile_id');
    }
}
