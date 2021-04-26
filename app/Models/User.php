<?php

namespace App\Models;

//   foi acrescentado para implementação da verificação do email
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// class User extends Authenticatable - sem verificação de email
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * 
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'Nome',
        'name',
        'email',
        'password',
        'corretorId',
        'funerariaId',
        'nivel',
        'status'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'funerariaId' => 'string',
        'corretorId' => 'string',
    ];


    public function funeraria()
    {
        return $this->hasOne('App\Models\funerariasModel', 'FunerariaId', 'funerariaId');
    }
    

}
