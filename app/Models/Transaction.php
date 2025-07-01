<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property string $estimated_weight_kg
 * @property string|null $actual_weight_kg
 * @property string|null $koin_earned
 * @property string $pickup_address
 * @property string $pickup_phone_number
 * @property string $status
 * @property string|null $admin_notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereActualWeightKg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAdminNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereEstimatedWeightKg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereKoinEarned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePickupAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePickupPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUserId($value)
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'estimated_weight_kg', 'actual_weight_kg',
        'koin_earned', 'pickup_address', 'pickup_phone_number', 'status',
        'admin_notes',
    ];

    protected $casts = [
        'estimated_weight_kg' => 'decimal:2',
        'actual_weight_kg' => 'decimal:2',
        'koin_earned' => 'decimal:2',
    ];

    // Definisikan relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
