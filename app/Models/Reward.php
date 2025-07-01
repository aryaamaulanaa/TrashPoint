<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $koin_required
 * @property int $stock
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RedeemTransaction> $redeemTransactions
 * @property-read int|null $redeem_transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Reward newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reward newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reward query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reward whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reward whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reward whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reward whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reward whereKoinRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reward whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reward whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reward whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'koin_required',
        'stock',
        'image',
    ];

    // Definisikan relasi
    public function redeemTransactions()
    {
        return $this->hasMany(RedeemTransaction::class);
    }
}