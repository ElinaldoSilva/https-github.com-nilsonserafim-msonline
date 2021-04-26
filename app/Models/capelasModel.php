<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class capelasModel extends Model
{
    use HasFactory;

    protected $table = "Capelas";
    protected $primaryKey = 'CapelaId';

    protected $fillable = ['CapelaId', 'Nome', 'Liberada'];

    protected $casts = [
        'CapelaId' => 'string',
    ];    

}
