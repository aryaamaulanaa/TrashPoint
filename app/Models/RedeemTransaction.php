<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $reward_id
 * @property int $koin_used
 * @property string $recipient_name
 * @property string $delivery_address
 * @property string $delivery_phone_number
 * @property string $status
 * @property string|null $admin_notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Reward $reward
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|RedeemTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RedeemTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RedeemTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|RedeemTransaction whereAdminNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedeemTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedeemTransaction whereDeliveryAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedeemTransaction whereDeliveryPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedeemTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedeemTransaction whereKoinUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedeemTransaction whereRecipientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedeemTransaction whereRewardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedeemTransaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedeemTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedeemTransaction whereUserId($value)
 * @property int $quantity
 * @method static \Illuminate\Database\Eloquent\Builder|RedeemTransaction whereQuantity($value)
 * @mixin \Eloquent
 */
class RedeemTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'reward_id', 'koin_used', 'quantity', 'recipient_name',
        'delivery_address', 'delivery_phone_number', 'status', 'admin_notes',
    ];

    // Definisikan relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }
}