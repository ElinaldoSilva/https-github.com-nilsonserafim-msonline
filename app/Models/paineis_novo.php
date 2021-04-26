<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paineis_novo extends Model
{
    use HasFactory;

    /**
     * Chave Primaria padrão "id", declaração da chave primaria fora do padrão
     *
     */
    protected $table = "Paineis";
    protected $primaryKey = 'PainelId';
    public $incrementing = false;

    protected $fillable = ['PainelId', 'Capela', 'Falecido', 'DataSepultamento', 'HorarioSepultamento', 'DataHoraLiberacaoCapela', 
                            'NomeFuneraria', 'Corretor', 'CorretorId', 'CMC', 'LocalFalecimento', 'DeclaracaoObito', 'MunicipioFalecimento', 
                            'TipoUrna', 'Cemiterio', 'UsuarioRegistro', 'DataHoraRegistro', 'destinacao', 'id', 'quadro', 'sepultura'];

    protected $casts = [
        'PainelId' => 'string',
        'CorretorId' => 'string',
    ];    
                                                    
}


