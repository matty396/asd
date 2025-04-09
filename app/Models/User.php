<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

/**
 *
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * validaciones
     */
    private static array $messages = [
        'required'          => 'El :attribute es obligatorio',
        'unique'            => 'El :attribute ya está utilizado por otro usuario.',
        'min'               => 'El :attribute es demasiado corto. (mínimo :min)',
        'max'               => 'El :attribute es demasiado largo. (máximo :max)',
        'name.required'     => 'El nombre es obligatorio',
        'name.unique'       => 'El nombre ya está utilizado por otro usuario.',
        'email'             => 'El :attribute debe ser un e-mail válido',
        'email.unique'      => 'El :attribute ya está utilizado por otro usuario.',
        'password.required' => 'La :attribute es obligatoria',
        'password.same'     => 'Las claves no coinciden',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return (bool)$this->email_verified_at;
    }

    /**
     * @return void
     */
    public function verify(): void
    {
        $this->update(['email_verified_at' => now()]);
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

//    public function usersVerify(): HasMany
//    {
//        return $this->hasMany(UsersVerify::class);
//    }
}
