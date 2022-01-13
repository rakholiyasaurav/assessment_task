<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;
class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = ['name','username', 'email', 'password', 'avatar', 'user_role','invitation_token','email_verified'];

    protected $visible = ['name','username', 'email', 'avatar', 'user_role','invitation_token','email_verified'];

    public function getRouteKeyName(): string
    {
        return 'username';
    }

    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function setInvitationTokenAttribute(string $invitationToken): void
    {
        $this->attributes['invitation_token'] = preg_replace('/[^A-Za-z0-9_$\-]/', 'Q', bcrypt($invitationToken));
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
