<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    use HasFactory;


    protected $fillable = [
        'nome_despesa',
        'descricao',
        'valor',
        'tipo',
        'categoria',
        'data',
    ];



    public static function categorias()
    {
        return [
            'emergencia',
            'lazer',
            'renda extra',
            'saude',
            'investimento',
            'educacao',
            'moradia',
            'transporte',
            'alimentacao',
            'roupas e acessorios',
            'entretenimento',
            'saude e beleza',
            'viagem'
        ];
    }
}
