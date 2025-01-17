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

Route::get('/despesas/tipo', [DespesaController::class, 'filtro']); 
Route::get('/despesas', [DespesaController::class, 'index']);
route::get('/despesa/{id}', [DespesaController::class, 'show']); 
Route::get('/despesas/search', [DespesaController::class, 'search']);
Route::delete('/despesa/{id}', [DespesaController::class, 'destroy']);
Route::post('/despesas', [DespesaController::class, 'store']); 
route::get('/gerar-pdf', [RelatorioController::class, 'gerarPDF']);
route::get('despesa/{id}/edit', [DespesaController::class, 'edit']);
route::put('despesa/{id}',[DespesaController::class, 'update']); 


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
