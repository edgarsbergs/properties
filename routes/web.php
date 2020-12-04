<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoApiController;
use App\Http\Controllers\PropertyController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/get_properties/{count?}', [DemoApiController::class, 'index'])->name('api.properties');

/* Admin panel */
Route::get('/admin/properties', [PropertyController::class, 'index'])->name('admin.properties');
Route::post('/admin/properties', [PropertyController::class, 'index'])->name('admin.propertiesSearch');
Route::get('/admin/property/{id}', [PropertyController::class, 'edit'])->name('admin.property');
Route::post('/admin/property/save', [PropertyController::class, 'update'])->name('admin.updateProperty');
Route::post('/admin/property/{id}/delete', [PropertyController::class, 'delete'])->name('admin.deleteProperty');
