<?php

use App\Http\Controllers\CustomerController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $totalCustomer = Customer::count();
    $totalKg = Customer::sum('kg');

    $currentDate = \Carbon\Carbon::today()->toDateString();
    $totalCustomerToday = Customer::whereDate('date', $currentDate)->count();

    $totalKgToday = Customer::whereDate('date', $currentDate)->sum('kg');

    return view('welcome', compact('totalCustomer', 'totalKg', 'totalCustomerToday', 'totalKgToday'));
});


Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
Route::get('/customerAdd', [CustomerController::class, 'customerAdd'])->name('customerAdd');
Route::post('/insertNewCustomer', [CustomerController::class, 'insertNewCustomer'])->name('insertNewCustomer');

Route::get('/editCustomer/{id}', [CustomerController::class, 'editCustomer'])->name('editCustomer');
Route::post('/updateCustomer/{id}', [CustomerController::class, 'updateCustomer'])->name('updateCustomer');

Route::get('/deleteCustomer/{id}', [CustomerController::class, 'deleteCustomer'])->name('deleteCustomer');

// Action: Completed will redirect the data to completed list
Route::get('/markCompleted/{id}', [CustomerController::class, 'markCompleted'])->name('markCompleted');
Route::get('/completedOrders', [CustomerController::class, 'completedOrders'])->name('completedOrders');
// New route for undoing delete
Route::post('/undoDelete/{id}', [CustomerController::class, 'undoDelete'])->name('undoDelete');
