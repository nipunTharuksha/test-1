<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Otp
 *
 * @property int $id
 * @property string $otp
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Otp newModelQuery()
 * @method static Builder|Otp newQuery()
 * @method static Builder|Otp query()
 * @method static Builder|Otp whereCreatedAt($value)
 * @method static Builder|Otp whereId($value)
 * @method static Builder|Otp whereOtp($value)
 * @method static Builder|Otp whereUpdatedAt($value)
 * @method static Builder|Otp whereUserId($value)
 * @mixin Eloquent
 */
class Otp extends Model
{
    use HasFactory;

    protected $fillable = ['otp', 'user_id'];
}
