<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GatewayController;
use App\Http\Controllers\InsuranceTypeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/show-invoice/{payment:unique_code}', [PaymentController::class, 'showInvoice'])->name('invoice.show');
Route::post('/purchase', [GatewayController::class, 'store'])->name('purchase.store');
Route::get('/purchase/verify', [GatewayController::class, 'verify'])->name('purchase.verify');

//ADMIN DASHBOARD ROUTES
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/profile', [AdminController::class, 'showProfile'])->name('profile.show');
    Route::put('/profile/update', [AdminController::class, 'udpdateUserInfo'])->name('profile.updateInfo');
    Route::put('/profile/update-password', [AdminController::class, 'updateUserPassword'])->name('profile.updatePassowrd');
    Route::group(['prefix' => '/insurance'], function () {
        Route::get('/', [InsuranceTypeController::class, 'index'])->name('insurances.list');
        Route::post('/create', [InsuranceTypeController::class, 'store'])->name('insurance.store');
        Route::get('/edit/{insuranceType}', [InsuranceTypeController::class, 'edit'])->name('insurance.edit');
        Route::put('/edit/{insuranceType}', [InsuranceTypeController::class, 'update'])->name('insurance.update');
        Route::delete('delete/{insuranceType}', [InsuranceTypeController::class, 'destroy'])->name('insurance.destory');
    });
    Route::group(['prefix' => 'customers'], function () {
        Route::get('/bulk-payments/{sale}', [PaymentController::class, 'bulkEdit'])->name('customer.bulk.payments');
        Route::post('/bulk-update-payments/{sale}', [PaymentController::class, 'bulkUpdate'])->name('customer.bulk.update.payments');
        Route::get('/', [CustomerController::class, 'index'])->name('customers.list');
        Route::post('/create', [CustomerController::class, 'store'])->name('customer.store');
        Route::get('/edit/{customer}', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::put('/edit/{customer}', [CustomerController::class, 'update'])->name('customer.update');
        Route::get('/{customer}/show-insurances', [SaleController::class, 'showCustomerInsurances'])->name('show.customer.insurances');
        Route::get('/show-payments/{sale}', [CustomerController::class, 'showPayments'])->name('customer.show.payments');
        Route::get('/update-payments/{payment}', [PaymentController::class, 'edit'])->name('show.customer.payment.form');
        Route::post('/update-payments/{sale}', [PaymentController::class, 'update'])->name('customer.update.payments');
        Route::get('/show-payments-status/{payment}', [PaymentController::class, 'showPaymentStatus'])->name('show.payments.status');
        Route::post('/update-payments-status/{payment}', [PaymentController::class, 'updateStatus'])->name('update.payments.status');
        Route::delete('/delete/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');
    });
    Route::group(['prefix' => 'sale'], function () {
        Route::get('/', [SaleController::class, 'index'])->name('sales.index');
        Route::post('/create', [SaleController::class, 'store'])->name('sales.store');
        Route::get('/{sale}/show-dates/', [SaleController::class, 'showDate'])->name('sales.show.date');
        Route::post('/{sale}/update-dates/', [SaleController::class, 'updateDates'])->name('sales.update.date');
        Route::get('/{sale}/edit/', [SaleController::class, 'edit'])->name('sales.edit');
        Route::post('/{sale}/edit/', [SaleController::class, 'update'])->name('sales.update');
        Route::post('/{sale}/delete', [SaleController::class, 'destroy'])->name('sales.delete');
        Route::get('/search', [SaleController::class, 'search'])->name('sales.search');
    });
    Route::group(['prefix' => 'payment'], function () {
        Route::get('/', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/show/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::get('/search', [PaymentController::class, 'search'])->name('payments.search');
        Route::get('/date-range', [PaymentController::class, 'dateRangeSearch'])->name('searchPayment.date.range');
    });

    Route::group(['prefix' => 'search'], function () {
        Route::get('/', [ReportController::class, 'index'])->name('search.result');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

