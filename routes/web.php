<?php
//namespace App\Http\Controllers;
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

Route::get('/','App\Http\Controllers\OperationControlleur@index');
Route::post('api/creercompte','App\Http\Controllers\OperationControlleur@creerCompte');
Route::delete('api/deletecompte/{id}','App\Http\Controllers\OperationControlleur@deletecompte');
Route::post('api/updatecompte/{id}','App\Http\Controllers\OperationControlleur@updatecompte');
Route::post('api/versement','App\Http\Controllers\OperationControlleur@versement');
Route::post('api/retrait','App\Http\Controllers\OperationControlleur@retrait');
Route::post('api/virement','App\Http\Controllers\OperationControlleur@virement');
Route::get('api/recherchercpte/{id}','App\Http\Controllers\OperationControlleur@recherchercpte');
Route::delete('api/annulerversement/{id}','App\Http\Controllers\OperationControlleur@annulerversement');
Route::delete('api/annulerretrait/{id}','App\Http\Controllers\OperationControlleur@annulerretrait');
Route::get('api/operationcompte/{id}','App\Http\Controllers\OperationControlleur@operationcompte');
