<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','OperationControlleur@index');
Route::post('api/creercompte','OperationControlleur@creerCompte');
Route::delete('api/deletecompte/{id}','OperationControlleur@deletecompte');
Route::post('api/updatecompte/{id}','OperationControlleur@updatecompte');
Route::post('api/versement','OperationControlleur@versement');
Route::post('api/retrait','OperationControlleur@retrait');
Route::post('api/virement','OperationControlleur@virement');
Route::get('api/recherchercpte/{id}','OperationControlleur@recherchercpte');
Route::delete('api/annulerversement/{id}','OperationControlleur@annulerversement');
Route::delete('api/annulerretrait/{id}','OperationControlleur@annulerretrait');
Route::get('api/operationcompte/{id}','OperationControlleur@operationcompte');
