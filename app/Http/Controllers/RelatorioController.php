<?php

namespace App\Http\Controllers;
use App\Models\Despesa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function gerarPDF()
    {
        $registros = Despesa::all();
        
        foreach ($registros as $registro) {
            $registro->total +=$registro->valor;
            $registro->valor_br = number_format($registro->valor, 2, ',', '.');
            $registro->data_br = date('d-m-Y', strtotime($registro->data));
            $registro->data_br =str_replace( '-' , '/', $registro->data_br);

            if ($registro->tipo === 'entrada') {
                $registro->style = 'text-transform: uppercase; color: limegreen';
            } else {
                $registro->style = 'text-transform: uppercase; color: red';
            }
  
        }

        $painel = Despesa::query()
        ->selectRaw('REPLACE(SUM(CASE WHEN tipo = ? THEN valor ELSE NULL END), ".", ",") AS total_valor_saida', ['saida'])
        ->selectRaw('REPLACE(SUM(CASE WHEN tipo = ? THEN valor ELSE NULL END), ".", ",") AS total_valor_entrada', ['entrada'])
        ->selectRaw('REPLACE(SUM(CASE WHEN tipo = ? THEN valor ELSE 0 END) - SUM(CASE WHEN tipo = ? THEN valor ELSE 0 END), ".", ",") AS saldo', ['entrada', 'saida'])
        ->get()
        ->first();
        
        $painel_css = $painel->saldo < 0 ? 'red;font-weight:400': 'blue;font-weight:400';

        $pdf = Pdf::loadView('relatorio', compact('registros', 'painel', 'painel_css'));
    
      
        // return $pdf->stream('relatorio.pdf');
    
      
         return $pdf->download('relatorio.pdf');
    }
    
    
}
