<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Passport\Client;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Token;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $user_name
 * @property string|null $avatar
 * @property string $email
 * @property string $user_role
 * @property Carbon|null $registered_at
 * @property Carbon|null $email_verified_at
 * @property int $otp_verified
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Client[] $clients
 * @property-read int|null $clients_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Otp|null $otp
 * @property-read Collection|Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User whereOtpVerified($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRegisteredAt($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUserName($value)
 * @method static Builder|User whereUserRole($value)
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'user_name',
        'avatar',
        'email',
        'user_role',
        'otp_verified',
        'registered_at',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'registered_at' => 'datetime',
    ];

    /**
     * @return HasOne
     */
    public function otp(): HasOne
    {
        return $this->hasOne(Otp::class);
    }
}
