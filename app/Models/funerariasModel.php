<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class funerariasModel extends Model
{
    use HasFactory;

    protected $table = "Funerarias";
    protected $primaryKey = 'FunerariaId';
    public $timestamps = false;

    protected $fillable = ['FunerariaId', 'Nome', 'CMC'];

    protected $casts = [
        'FunerariaId' => 'string',
    ];    
}
