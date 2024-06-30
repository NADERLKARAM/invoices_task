<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/', [InvoiceController::class, 'create'])->name('invoices.create');
Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::get('/invoices/{invoice}/print', [InvoiceController::class,'print'])->name('invoices.print');
Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
Route::delete('invoices/{id}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');