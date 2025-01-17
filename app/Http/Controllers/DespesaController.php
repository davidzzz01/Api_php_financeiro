<?php

namespace App\Http\Controllers;
use App\Models\Despesa;
use Illuminate\Http\Request;

class DespesaController extends Controller
{

    public function index(){

    $categorias = \App\Models\Despesa::categorias();

     $query= Despesa::query()
     ->select('despesas.*');
     $registros=$query->get();

     $painel = Despesa::query()
    ->selectRaw('REPLACE(SUM(CASE WHEN tipo = ? THEN valor ELSE NULL END), ".", ",") AS total_valor_saida', ['saida'])
    ->selectRaw('REPLACE(SUM(CASE WHEN tipo = ? THEN valor ELSE NULL END), ".", ",") AS total_valor_entrada', ['entrada'])
    ->selectRaw('REPLACE(MIN(CASE WHEN tipo = ? THEN valor ELSE NULL END), ".", ",") AS min_valor_saida', ['saida'])
    ->selectRaw('REPLACE(MAX(CASE WHEN tipo = ? THEN valor ELSE NULL END), ".", ",") AS max_valor_saida', ['saida'])
    ->selectRaw('REPLACE(MIN(CASE WHEN tipo = ? THEN valor ELSE NULL END), ".", ",") AS min_valor_entrada', ['entrada'])
    ->selectRaw('REPLACE(MAX(CASE WHEN tipo = ? THEN valor ELSE NULL END), ".", ",") AS max_valor_entrada', ['entrada'])
    ->selectRaw('REPLACE(SUM(CASE WHEN tipo = ? THEN valor ELSE 0 END) - SUM(CASE WHEN tipo = ? THEN valor ELSE 0 END), ".", ",") AS saldo', ['entrada', 'saida'])
    ->get();

    $estilo = '';

    if ( $painel[0]['saldo'] > 0) {
        $estilo = 'RGB(0,136,150)';
    } elseif($painel[0]['saldo'] === 0 ) {
        $estilo = 'grey';
    }else {
        $estilo = 'red';
    }

    $card = array(
        [
            "titulo" => "Entradas",
            "valor_total"=>$painel[0]['total_valor_entrada'],
            "estilo"=>"color:green;",
            "texto1" => "Menor Receita:",
            "valor1"=> $painel[0]['min_valor_entrada'],
            "texto2" => "Maior Receita:",
            "valor2"=>$painel[0]['max_valor_entrada'],

        ],
        [
            "titulo" => "Saídas",
            "valor_total"=>$painel[0]['total_valor_saida'],
            "estilo"=>"color:red",
            "texto1" => "Menor Despesa:",
            "valor1"=> $painel[0]['min_valor_saida'],
            "texto2" => "Maior Despesa:",
            "valor2"=>$painel[0]['max_valor_saida'],

        ],
        [
            "titulo"=>"Saldo",
            "valor1"=>$painel[0]['saldo'],
            "texto3"=> "Total de despensas do mes ",
            "icone"=>'<i style="color:RGB(0,136,150)" class="fa-solid fa-sack-dollar fa-6x "></i>',
            "estilo" => "color: $estilo;"
        ]
        );



     foreach( $registros as $registro){
          $registro->valor_br = number_format($registro->valor,2, ',' , '.');
          $registro->data_br= date('d-m-Y', strtotime($registro->data));

          if($registro->tipo==='entrada'){
            $registro->class = 'text-align:center;text-transform:UPPERCASE;color:limegreen';
          }else{
            $registro->class = 'text-align:center;text-transform:UPPERCASE;color:red';
          }

        }

        return response()->json([

            'registros' => $registros,
            'categorias' => $categorias,
            'painel'=>$painel,
            'card'=> $card,
            'estilo'=>$estilo


        ]);
    }





    public function validateRequest(Request $request){
        $request->validate([
            'nome_despesa' => 'required|string|max:255',
            'descricao'    => 'nullable|string|max:255',
            'valor'        => 'required|numeric|min:0',
            'tipo'         => 'required|string|in:entrada,saida',
            'categoria'    => 'required|string|max:255',
            'data'         => 'required|date',
        ]);
    }

    public function store(Request $request)
    {
       self::validateRequest($request);


        $registros=Despesa::create($request->all());

        return response()->json([
            'registros'=>$registros
        ]);
    }


    public function show(string $id)
    {
        $despesa = Despesa::find($id);


        if ($despesa) {
            return response()->json($despesa, 200);
        }

        return response()->json(['message' => 'Despesa não encontrada'], 404);
    }


    public function edit(string $id)
    {
      $despesa = Despesa::whereId($id);
      return response()->json($despesa, 200);
    }


    public function update(Request $request, string $id)
    {

        self::validateRequest($request);
        Despesa::update($request->all());
    }


    public function destroy(int $id)
    {
        $despesa = Despesa::whereId($id)->delete();
        return response()->json(['message' => 'Despesa deletada com sucesso']);


    }

    public function filtro(Request $request){

        $tipo = $request->query('tipo');

        $despesas = Despesa:: when(isset($tipo))->where('tipo', $tipo)->get();

        return response()->json($despesas);

    }


    public function search(Request $request)
    {
        $despesa = $request->input('despesa');
    
        
        $despesas = Despesa::when($despesa, function ($query) use ($despesa) {
            return $query->where('nome_despesa', 'like', '%' . $despesa . '%');
        })->get();
    
        return response()->json($despesas);
    }
    

    // public function search(Request $request){
    // $despesa=$request->input('despesa');
    // return Despesa::when(isset($despesa))->where('nome_despesa', 'like','%'.$despesa.'%')->get();



    // return response()->json($despesas);
    // }
}
