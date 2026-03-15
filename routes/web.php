<?php

use App\Http\Controllers\RoutingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

require __DIR__ . '/auth.php';

Route::prefix('admin')->name('admin.')->group(function () {

    //admin
    Route::resource('users', UserController::class);

    //customer
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy'); // Delete customer

    Route::resource('employees', EmployeeController::class);

    Route::resource('donations', DonationController::class);
      Route::get('donations/{id}/receipt/pdf', [DonationController::class, 'receiptPdf'])->name('donations.receipt.pdf');

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/donation-detailed', [ReportController::class, 'donationDetailedReport'])->name('donation.detailed');
        Route::get('/employee-donation-summary', [ReportController::class, 'employeeDonationSummary'])->name('employee.donation.summary');
        Route::get('/donation-type-summary', [ReportController::class, 'donationTypeSummary'])->name('donation.type.summary');
        Route::get('/employee-master', [ReportController::class, 'employeeMasterReport'])->name('employee.master');

        Route::get('/donation-detailed/export/excel', [ReportController::class, 'exportDonationDetailedExcel'])->name('donation.detailed.export.excel');
        Route::get('/donation-detailed/export/pdf', [ReportController::class, 'exportDonationDetailedPdf'])->name('donation.detailed.export.pdf');

        Route::get('/employee-donation-summary/export/excel', [ReportController::class, 'exportEmployeeDonationSummaryExcel'])->name('employee.donation.summary.export.excel');
        Route::get('/employee-donation-summary/export/pdf', [ReportController::class, 'exportEmployeeDonationSummaryPdf'])->name('employee.donation.summary.export.pdf');

        Route::get('/donation-type-summary/export/excel', [ReportController::class, 'exportDonationTypeSummaryExcel'])->name('donation.type.summary.export.excel');
        Route::get('/donation-type-summary/export/pdf', [ReportController::class, 'exportDonationTypeSummaryPdf'])->name('donation.type.summary.export.pdf');

        Route::get('/employee-master/export/excel', [ReportController::class, 'exportEmployeeMasterExcel'])->name('employee.master.export.excel');
        Route::get('/employee-master/export/pdf', [ReportController::class, 'exportEmployeeMasterPdf'])->name('employee.master.export.pdf');
    });

    //profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});



Route::group(['prefix' => '/', 'middleware' => 'auth'], function () {
    Route::get('', [RoutingController::class, 'index'])->name('root');
    Route::get('{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
    Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    Route::get('{any}', [RoutingController::class, 'root'])->name('any');
});


Route::get('/login', function () {
    return view('auth.signin');
})->name('login');

// Login action
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
   Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
   

//  Route::get('/', function () {
//         return view('index'); // create resources/views/dashboard.blade.php
//     });
});


