<?php
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\RelatorioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/despesas', [DespesaController::class, 'filtro']); //retorna items por tipo (entrada ou saida)
Route::get('/despesas', [DespesaController::class, 'index']); // retorna todos os registros
route::get('/despesa/{id}', [DespesaController::class, 'show']); /// retorna item por id
Route::get('/despesa/search', [DespesaController::class, 'search']); //pesquisa por nome
Route::delete('/despesa/{id}', [DespesaController::class, 'destroy']); //exclui
Route::post('/despesa', [DespesaController::class, 'store']); ///cadastra novas despesas
route::get('/gerar-pdf', [RelatorioController::class, 'gerarPDF']); ///gera um relatório 
route::get('desoesa/{id}/edit', [DespesaController::class, 'edit']); //pagina para edição do registro
route::put('despesa/{id}',[DespesaController::class, 'update']); // faz atualização dos registros


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
