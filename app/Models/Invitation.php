<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * App\Models\Invitation
 *
 * @property int $id
 * @property string $email
 * @property string $token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static Builder|Invitation newModelQuery()
 * @method static Builder|Invitation newQuery()
 * @method static Builder|Invitation query()
 * @method static Builder|Invitation whereCreatedAt($value)
 * @method static Builder|Invitation whereEmail($value)
 * @method static Builder|Invitation whereId($value)
 * @method static Builder|Invitation whereToken($value)
 * @method static Builder|Invitation whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Invitation extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['email', 'token'];
}
