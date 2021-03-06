<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generateAndSaveToken()
    {
        $this->remember_token = Str::random(40);
        $this->save();
        return $this->remember_token;
    }

    public function getApiResponseBody($user)
    {
        $token = $this->generateAndSaveToken();

        $data = [
            'data' => [
                'api_token' => $token,
                'email' =>  $user->email,
                'id' =>  $user->id,
                'name' =>  $user->name,
                'surname' =>  $user->surname,
            ]
        ];

        return $data;
    }

    public function setPasswordAttribute($value)

    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function userUpdate($token, $validation)
    {

        $user = User::where('remember_token', $token)->first();
        $user->name = $validation['name'];
        $user->password = $validation['password'];
        $user->surname = $validation['surname'];

        $token = $user->generateAndSaveToken();

        $data = [
            'data' => [
                'api_token' => $token,
                'email' => $user->email,
                'id' => $user->id,
                'name' => $user->name,
                'surname' => $user->surname,
            ]
        ];

        return $data;
    }
}
